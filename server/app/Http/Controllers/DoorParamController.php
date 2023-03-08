<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Helpers\PDFHelper;
use App\Models\DoorParam;
use App\Models\DoorParamsType;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Validator;


class DoorParamController extends Controller
{
  public function getDoorParams()
  {
    $doorParamTypes = DoorParamsType::with('door_params')->get();
    return $doorParamTypes->pluck('door_params', 'type');
  }
  public function sendNotification(Request $request)
  {
    $fileName = 'doc.pdf';
    $path = storage_path('/storage') . $fileName;
    // содержимое pdf
    $pdfContent = '';


    // проверяем что все id параметров двери есть в бд
    $validator = Validator::make($request->all(), [
      'ids' => 'required|array',
      'ids.*' => 'exists:door_params,id',
    ]);

    if ($validator->fails())
      return Response('not found door params id', 404);

    $ids = $request->input('ids');

    $doorParams = DoorParam::with('door_params_type')->find($ids);
    $doorParamTypeIds = [];

    // проверяем что все выбранные id параметров типов 
    // двери (цвет отделки, отыкрывание) уникальны, кроме аксессуаров
    foreach ($doorParams as $doorParam) {
      $doorParamTypeId = $doorParam->door_params_type['id'];
      // если тип параметра аксессуар
      // то пропускаем итерацию
      if ($doorParamTypeId === 2) {
        continue;
      }
      if (in_array($doorParamTypeId, $doorParamTypeIds)) {
        return Response('door params type id must be unique for not accessories types', 400);
      }
      $doorParamTypeIds[] = $doorParamTypeId;
    }

    // cоздаем таблицу для pdf файла и заполняем его
    $pdfContent = '
          <table border="1" cellspacing="5" cellpadding="10" style="text-align: center;">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Заголовок</th>
                    <th>Тип</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
        ';

    $totalPrice = 0;

    foreach ($doorParams as $doorParam) {
      $totalPrice += $doorParam->price;
      $pdfContent .= "
        <tr>
          <td>$doorParam->id</td>
          <td>$doorParam->title</td>
          <td>{$doorParam->door_params_type["type"]}</td>
         
          <td>$doorParam->price руб.</td>
        </tr>
      ";
    }

    $pdfContent .= "
        <tr>
          <td colspan='3'>Итого</td>
          <td>$totalPrice руб.</td>
        </tr>
      </tbody>
    </table>";


    $pdf = new PDFHelper($pdfContent);

    // создание и сохрание в локальной папке
    $pdf->savePdfInFolder($path);

    $users = new User;
    // отправка сообщения всем в группе в телеграмме
    Notification::send($users, new SendNotification('file', $path, $fileName, 'document'));
    File::delete($path);
    return 'ok';
  }
}