<template>
  <div>
    <div id="modal3" class="modal">
      <form id="form-salvar">
        <div class="row">
          <div class="input-field col s6">
            <input v-model="produto.nome" id="nome" type="text" class="validate" />
            <label for="nome">Nome</label>
          </div>
          <div class="input-field col s6">
            <textarea v-model="produto.descricao" id="descricao" class="materialize-textarea"></textarea>
            <label for="descricao">Descricao</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input v-money="money" v-model.lazy="produto.valor" id="valor" type="text" class="validate" />
            <label for="valor">Valor</label>
          </div>
          <div class="input-field col s6">
            <input v-model="produto.quantidade" id="quantidade" type="number" class="validate" />
            <label for="quantidade">Quantidade</label>
          </div>
        </div>

        <button @click.prevent="salvar" class="btn waves-effect waves-light right" name="action">
          Submit
          <i class="material-icons right">send</i>
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.modal.open {
  min-width: 90%;
  min-height: 80%;
}
#form-salvar {
  padding: 2em;
}
</style>

<script>
import M from "materialize-css";
import { VMoney } from "v-money";
import { pJwtFetch } from "../suporte/helpers-jwt";
let elem;
document.addEventListener("DOMContentLoaded", function() {
  elem = document.querySelector("#modal3");
  let instances = M.Modal.init(elem, {});
});
function ativarLabels() {
  let labels = document.querySelectorAll("label");
  labels.forEach((lb, i) => {
    lb.classList.add("active");
  });
}
function desativarLabels() {
  let labels = document.querySelectorAll("label");
  labels.forEach((lb, i) => {
    lb.classList.remove("active");
  });
}
export default {
  name: "FormSalvaProduto",
  data() {
    return {
      produto: {
        id: "",
        nome: "",
        descricao: "",
        valor: "",
        quantidade: ""
      },
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "R$ ",
        // suffix: " #",
        precision: 2,
        masked: false /* doesn't work with directive */
      }
    };
  },
  methods: {
    salvar: function() {
      this.produto.valorSanitizado = parseFloat(String(this.produto.valor).replace("R$ ","").replace(/\./g,"").replace(",", ".").replace(" #", ""))
      let opcoes = {
        url: this.apiurl + "produto-salvar",
        method: "post",
        body: JSON.stringify(this.produto)
      };

      pJwtFetch(opcoes).then(mensagem => {
        M.toast({ html: mensagem });
        M.Modal.getInstance(elem).close();
        this.$emit("recarregar");
      });
    },
    abrir: function(produtoTemp) {
      this.produto = produtoTemp;
      M.Modal.getInstance(elem).open();
      desativarLabels();
      if (this.produto.id) {
        ativarLabels();
      }
    }
  },
  props: ["apiurl"],
  directives: { money: VMoney }
};
</script>

