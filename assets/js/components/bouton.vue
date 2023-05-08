<template>
    <a id="navbar" href="/courses/historique">{{ label }}</a>
</template>
  
<script>
  export default {
    name: "Button",
    class: "dropdown-item",
    props: {
      label: String,
    },
  };
</script>
<style>
#navbar{
  text-decoration: none;
  color: black;
}

</style>