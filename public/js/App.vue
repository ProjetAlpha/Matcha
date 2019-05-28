<template>
  <div>
    <h1>Hello {{name}}</h1>
    <div>
      <h1>Hello {{name}}</h1>
    </div>
    <div>
      <h1>Hello {{name}}</h1>
    </div>
  </div>
</template>

<script>
    export default{
        data(){
            props: ['name']
        }
    }
</script>
