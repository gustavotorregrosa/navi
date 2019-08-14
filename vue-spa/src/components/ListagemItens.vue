<template>
  <div>
    <div v-if="estaLogado" class="espacado">
      <a @click.prevent="abrirForm()" class="modal-trigger btn-floating btn-large waves-effect waves-light red btn-small pulse right">
        <i class="material-icons">add</i>
      </a>
      <table>
        <thead>
          <th>Nome</th>
          <th>Botões</th>
        </thead>
        <tbody>
          <tr v-bind:key="produto.id" v-for="(produto, index) in produtos">
            <td>{{produto.nome}}</td>
            <td>
              <a class="waves-effect waves-light btn-small red darken-1" @click.prevent="deletar(index)"><i class="material-icons">delete</i></a>
              &nbsp; &nbsp; &nbsp;
              <a class="waves-effect waves-light btn-small" @click.prevent="abrirForm(index)"><i class="material-icons">edit</i></a> 
            </td>
          </tr>
        </tbody>
      </table>
      <ValorTotal :valortotal="valortotal"/>

    </div>



    <FormSalvaProduto @recarregar="listaitens()" :apiurl="apiurl" ref="form"/>
    <ModalDeletar @recarregar="listaitens()" :apiurl="apiurl" ref="deletar"/>
  </div>
</template>

<script>
import { pJwtFetch } from "../suporte/helpers-jwt";
import FormSalvaProduto from "./FormSalvaProduto.vue";
import ModalDeletar from "./ModalDeletar.vue";
import ValorTotal from "./ValorTotal.vue";
export default {
  name: "ListagemItens",
  data() {
    return {
      produtos: []
    };
  },

  computed: {
    valortotal: function(){
      let valor = 0
      this.produtos.forEach(element => {
          valor += element.quantidade * parseFloat(element.valor)
      });
      return valor
      
    }
  },

  methods: {
    deletar: function(i){
      let produtoTemp = {}
      if(i !== null){
        produtoTemp = this.produtos[i]
      }
      this.$refs.deletar.abrir(produtoTemp)
    },
    abrirForm: function(i = null){
      let produtoTemp = {}
      if(i !== null){
        produtoTemp = this.produtos[i]
      }
      this.$refs.form.abrir(produtoTemp)
    },
    listaitens: function() {
      let opcoes = {
        url: this.apiurl + "lista-produtos",
        method: "get"
      };

      pJwtFetch(opcoes)
        .then(resultado => {
          this.produtos = resultado
        })
        .catch(codigo => {
          if (this.estaLogado) {
            this.$emit("abrirmodallogin");
          }
        });
    }
  },

  mounted: function() {
    this.listaitens();
  },
  props: ["estaLogado", "apiurl"],
  watch: {
    estaLogado: function(newVal, oldVal) {
      this.listaitens();
    }
  },
  components: {
    FormSalvaProduto,
    ModalDeletar,
    ValorTotal
  }
};
</script>


<style scoped>
.espacado {
  margin-top: 5em;
}
</style>

