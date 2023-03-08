<template>
  <div class="door-parameters">
    <h2 class="door-parameters__title">Параметры</h2>
    <div v-if="isParamsFetched">
      <div class="door-parameters__item" v-if="availableParams.paint">
        <div class="door-parameters__item-title">Цвет покраски:</div>
        <a-select
          @change="onSelectParam($event, 'paint')"
          label-in-value
          :options="availableParams.paint"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Выберите цвет"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <div class="door-parameters__item" v-if="availableParams.film">
        <div class="door-parameters__item-title">Цвет пленки:</div>
        <a-select
          @change="onSelectParam($event, 'film')"
          label-in-value
          :options="availableParams.film"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Выберите цвет"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <div class="door-parameters__item" v-if="availableParams.handle">
        <div class="door-parameters__item-title">Цвет ручки:</div>
        <a-select
          @change="onSelectParam($event, 'handle')"
          label-in-value
          :options="availableParams.handle"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Выберите цвет"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <div class="door-parameters__item" v-if="availableParams.width">
        <div class="door-parameters__item-title">Ширина:</div>
        <a-select
          @change="onSelectParam($event, 'width')"
          label-in-value
          :options="availableParams.width"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Выберите ширина"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <div class="door-parameters__item" v-if="availableParams.height">
        <div class="door-parameters__item-title">Высота:</div>
        <a-select
          @change="onSelectParam($event, 'height')"
          label-in-value
          :options="availableParams.height"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Выберите высоту"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <div class="door-parameters__item" v-if="availableParams.side">
        <div class="door-parameters__item-title">Открывание:</div>
        <a-select
          @change="onSelectParam($event, 'side')"
          label-in-value
          :options="availableParams.side"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Открывание"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <div class="door-parameters__item" v-if="availableParams.accessories">
        <div class="door-parameters__item-title">Аксессуары:</div>
        <a-select
          mode="tags"
          @change="onSelectParam($event, 'accessories', true)"
          label-in-value
          :options="availableParams.accessories"
          :fieldNames="fieldNames"
          :size="selectTagSize"
          placeholder="Аксессуары:"
          class="door-parameters__item-select"
        ></a-select>
      </div>
      <template v-if="totalPrice">
        <div class="door-parameters__total-price">
          <span>Итого:</span>
          {{ prettyPrice(totalPrice) }} руб.
        </div>
        <div align="right" style="margin-top: 20px">
          <a-button @click="uploadPackage" :loading="!doorParamsStore.isParamsFetched" type="primary"
            >Отправить комплектацию</a-button
          >
        </div>
      </template>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { SelectProps } from 'ant-design-vue'
import { onBeforeMount } from 'vue'
import { storeToRefs } from 'pinia'

import { useDoorParamsStore } from '@/stores/doorParams'
import { prettyPrice } from '@/libs/helper'
import type { IAvailableParams } from '@/types/doorParams'

const doorParamsStore = useDoorParamsStore()
const { isParamsFetched, availableParams, selectedParams, totalPrice } =
  storeToRefs(doorParamsStore)
const selectTagSize = 'middle'
const fieldNames = {
  label: 'title',
  value: 'id'
}

onBeforeMount(async () => {
  await doorParamsStore.fetchAvailableParams()
})

async function uploadPackage() {
  await doorParamsStore.uploadPackage()
}

function onSelectParam(
  selectedItem: SelectProps['onChange'],
  paramName: keyof IAvailableParams,
  isArray: boolean = false
) {
  const params = availableParams.value?.[paramName]
  if (!params) return
  if (isArray) {
    // @ts-ignore
    const lastItem: paramType = selectedItem.map((o) => o.option).at(-1)
    // @ts-ignore
    selectedParams.value?.[paramName].push(lastItem)
    return
  }
  // @ts-ignore
  selectedParams.value[paramName] = selectedItem?.option
}
</script>

<style lang="scss">
$maxWidth: 900px;
.door-parameters {
  @media (max-width: $maxWidth) {
    max-width: 600px;
  }
  &__title {
    @media (max-width: $maxWidth) {
      text-align: center;
    }
  }
  &__item {
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    &-title {
      width: 150px;
      text-align: right;
    }
    &-select {
      width: 200px;
      @media (max-width: 500px) {
        width: 150px;
      }
      @media (max-width: 400px) {
        width: 100px;
      }
    }
  }
  &__total-price {
    text-align: right;
    font-weight: bold;
    font-size: 25px;
    margin-top: 40px;
    & > span {
      margin-right: 40px;
    }
  }
}
</style>
