import { defineStore } from 'pinia'
import api from '@/libs/api'
import type { useDoorParams, IAvailableParams, ISelectedParams } from '@/types/doorParams'

export const useDoorParamsStore = defineStore('doorParams', {
  state: (): useDoorParams => {
    return {
      isParamsFetched: false,
      hasParamsFetchedError: false,
      selectedParams: {
        paint: null,
        film: null,
        handle: null,
        width: null,
        height: null,
        side: null,
        accessories: []
      },
      availableParams: {
        paint: null,
        film: null,
        handle: null,
        width: null,
        height: null,
        side: null,
        accessories: null
      }
    }
  },
  getters: {
    totalPrice: ({ selectedParams }) => {
      let result = 0
      // если не выбрано аксессуары, то ничего показываем
      if (!selectedParams.accessories?.length) {
        return null
      }
      // перебираем по каждому параметру и находим общую цену
      for (let paramName in selectedParams) {
        const param = selectedParams[paramName as keyof ISelectedParams]
        // если хотя бы один параметр не выбран, то ничего показываем
        if (!param) return
        // если параметр это массив
        // то перебираем этот параметр
        if (Array.isArray(param)) {
          for (let p of param) {
            result += p.price
          }
          continue
        }
        result += param.price
      }
      return result
    }
  },
  actions: {
    async fetchAvailableParams() {
      try {
        const { data } = await api.get<IAvailableParams>('door-params')
        this.availableParams = data

        this.isParamsFetched = true
      } catch (err) {
        console.error(err)
        this.hasParamsFetchedError = true
      }
    },
    async uploadPackage() {
      try {
        const ids = []
        // перебираем выбранные параметры, чтобы получить их id
        for (let paramName of Object.keys(this.selectedParams)) {
          const param = this.selectedParams[paramName as keyof ISelectedParams]
          if (!param) return
          if (Array.isArray(param)) {
            if (!param.length) return
            for (let i = 0; i < param.length; i++) {
              ids.push(param[i].id)
            }
            continue
          }
          ids.push(param.id)
        }
        await api.post('door-params/send', { ids })
      } catch (err) {
        console.error(err)
        this.hasParamsFetchedError = true
      }
    }
  }
})
