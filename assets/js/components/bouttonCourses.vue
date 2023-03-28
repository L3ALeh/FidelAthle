<template>
    <div>
      <Button :label="labelBouton" />
    </div>
  </template>
  
<script>
  import Button from "./bouton.vue";
  
  export default {
    components: {
      Button,
      labelBouton : null
    },
    created()
    {
        const appElement = document.getElementById('bouton-courses')
        const labelString = appElement.getAttribute('data')
        this.labelBouton = labelString
    }
  };
</script>
  