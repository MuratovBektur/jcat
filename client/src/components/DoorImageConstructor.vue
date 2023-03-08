<template>
  <svg
    class="door-image-constructor"
    xmlns="http://www.w3.org/2000/svg"
    version="1.1"
    height="535px"
    width="215px"
    :class="{
      'door-image-constructor_reverse': canReverse
    }"
    xmlns:xlink="http://www.w3.org/1999/xlink"
  >
    <g>
      <path
        style="opacity: 1"
        :fill="doorParams?.paint?.value || defaultColor"
        d="M -0.5,-0.5 C 71.1667,-0.5 142.833,-0.5 214.5,-0.5C 214.5,177.833 214.5,356.167 214.5,534.5C 142.833,534.5 71.1667,534.5 -0.5,534.5C -0.5,356.167 -0.5,177.833 -0.5,-0.5 Z"
      />
    </g>
    <g>
      <path
        style="opacity: 1"
        :fill="doorParams?.film?.value || defaultColor"
        d="M 11.5,15.5 C 73.8333,15.5 136.167,15.5 198.5,15.5C 198.5,181.5 198.5,347.5 198.5,513.5C 136.167,513.5 73.8333,513.5 11.5,513.5C 11.5,347.5 11.5,181.5 11.5,15.5 Z"
      />
    </g>
    <g>
      <path
        style="opacity: 1"
        :fill="doorParams?.film?.value || defaultColor"
        d="M 12.5,16.5 C 74.1667,16.5 135.833,16.5 197.5,16.5C 197.5,181.833 197.5,347.167 197.5,512.5C 135.833,512.5 74.1667,512.5 12.5,512.5C 12.5,347.167 12.5,181.833 12.5,16.5 Z"
      />
    </g>
    <g>
      <path
        style="opacity: 1"
        :fill="doorParams?.handle?.value || doorParams?.film?.value || defaultColor"
        d="M 20.5,248.5 C 38.5,248.5 56.5,248.5 74.5,248.5C 74.5,252.167 74.5,255.833 74.5,259.5C 56.5,259.5 38.5,259.5 20.5,259.5C 20.5,255.833 20.5,252.167 20.5,248.5 Z"
      />
    </g>
  </svg>
</template>

<script setup lang="ts">
import { computed, defineProps, toRefs, watch } from 'vue'
import type { PropType } from 'vue'

import type { ISelectedParams } from '@/types/doorParams'

const props = defineProps({
  doorParams: Object as PropType<ISelectedParams>,
  reverse: {
    type: Boolean,
    default: false
  }
})

const { doorParams, reverse } = toRefs(props)

const canReverse = computed(() => {
  const openingSide = doorParams?.value?.side
  if (reverse.value) {
    return !openingSide || openingSide.value === 'right'
  }
  return openingSide && openingSide.value === 'left'
})

watch(
  () => doorParams,
  (doorParams) => console.log(doorParams)
)

const defaultColor = '#bfbfbf'
</script>

<style lang="scss" scoped>
.door-image-constructor {
  transition: all 0.3s linear;
  &_reverse {
    transform: rotateY(180deg);
  }
}
</style>
