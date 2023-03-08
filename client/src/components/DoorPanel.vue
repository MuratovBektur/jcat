<template>
  <div class="door-panel">
    <div class="door-panel__item">
      <DoorImageConstructor :doorParams="doorParams" />
      <div>Вид снаружи</div>
    </div>
    <div class="door-panel__item">
      <DoorImageConstructor :doorParams="doorParams" :reverse="true" />
      <div>Вид изнутри</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import DoorImageConstructor from './DoorImageConstructor.vue'
import { useDoorParamsStore } from '@/stores/doorParams'
import { storeToRefs } from 'pinia'

const doorParamsStore = useDoorParamsStore()
const { selectedParams: doorParams } = storeToRefs(doorParamsStore)
</script>

<style lang="scss" scoped>
$width: 600px;
.door-panel {
  display: flex;
  text-align: center;
  @media (max-width: $width) {
    flex-direction: column;
  }
  &__item {
    &:first-child {
      margin-right: 20px;
      @media (max-width: $width) {
        margin-right: 0;
      }
    }
  }
}
</style>
