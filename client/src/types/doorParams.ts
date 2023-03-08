export type paramType = {
  title: string
  value: string
  id: number
  price: number
  [key: string]: string | number
}

export interface ISelectedParams {
  paint: null | paramType
  film: null | paramType
  handle: null | paramType
  width: null | paramType
  height: null | paramType
  side: null | paramType
  accessories: Array<paramType>
}

export interface IAvailableParams {
  paint: null | Array<paramType>
  film: null | Array<paramType>
  handle: null | Array<paramType>
  width: null | Array<paramType>
  height: null | Array<paramType>
  side: null | Array<paramType>
  accessories: null | Array<paramType>
}

export type useDoorParams = {
  hasParamsFetchedError: boolean
  isParamsFetched: boolean
  selectedParams: ISelectedParams
  availableParams: IAvailableParams
}
