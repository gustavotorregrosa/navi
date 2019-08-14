<template>
  <div>
    <br />
    <br />
    <br />
    <div class="row">
      <div class="right col s12 m2">
        <div class="card-panel teal">
          <span class="white-text">Valor total: R$ {{valortotal}}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ValorTotal",
  props: ["valortotal"]
};
</script>

<style>
</style>