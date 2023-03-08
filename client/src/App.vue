<script setup lang="ts">
import DoorParameters from '@/components/DoorParameters.vue'
import DoorPanel from '@/components/DoorPanel.vue'
</script>

<template>
  <div class="app">
    <div class="app__content">
      <h1 class="app__title">Конфигуратор входной двери</h1>
      <div class="app__body">
        <DoorPanel />
        <DoorParameters />
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
$maxWidth: 900px;
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

*,
*:before,
*:after {
  font-family: Roboto, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
.app {
  background-color: #ededed;
  min-height: 100vh;
  &__content {
    max-width: 1000px;
    padding: 30px;
    margin: auto;
  }
  &__title {
    text-align: center;
  }
  &__body {
    display: flex;
    & > *:last-child {
      margin-left: 30px;
      flex-grow: 1;
    }
    @media (max-width: $maxWidth) {
      flex-direction: column;
      align-items: center;
      & > *:last-child {
        margin-left: 0;
        margin-top: 30px;
        flex-grow: 0;
        min-width: 360px;
      }
    }
    @media (max-width: 400px) {
      & > *:last-child {
        min-width: 300px;
      }
    }
  }
}
</style>
