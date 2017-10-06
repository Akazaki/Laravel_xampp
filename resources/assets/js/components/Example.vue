<template>
  <h1>Hello, {{ name }}</h1>
</template>

<script>
  export default {
    data () {
      return {
        name: 'Kazuya'
      }
    },
  }
</script>

<style>
  .h1 {
    border-bottom: 1px;
  }
</style>