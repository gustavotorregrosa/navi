<template>
  <div id="app">
    <header>
      <NavBar @logout="logout()" :usuario="usuario" :estaLogado="estaLogado" />
    </header>
    <main>
      <div class="container">
        <Apresentacao :estaLogado="estaLogado"/>
        <ListagemItens @abrirmodallogin="abrirmodallogin" :apiurl="apiurl" :estaLogado="estaLogado" />
        <ModalLogin ref="modallogin" @logarusuario="logarusuario" />
        <ModalRegistro ref="modalregistro" @registrarusuario="registrarusuario" />
      </div>
    </main>
  </div>
</template>

<script>
import NavBar from "./components/NavBar.vue";
import ListagemItens from "./components/ListagemItens.vue";
import ModalLogin from "./components/ModalLogin.vue";
import ModalRegistro from "./components/ModalRegistro.vue";
import Apresentacao from "./components/Apresentacao.vue";
import "materialize-css";
import "materialize-css/dist/css/materialize.min.css";


export default {
  name: "app",
  data() {
    return {
      usuario: "",
      apiurl: "http://jwt-backend-navi.gustavotorregrosa.com/api/"
    };
  },
  computed: {
    estaLogado: function() {
      if (this.usuario) {
        return true;
      }
      return false;
    }
  },

  mounted: function() {
    this.usuario = JSON.parse(localStorage.getItem("meuUsuario"));
  },

  methods: {
    logout: function() {
      localStorage.removeItem("meuJwt");
      localStorage.removeItem("meuUsuario");
      this.usuario = null;
    },
    logarusuario: function(usuario) {
      let opcoes = {
        url: this.apiurl + "usuario/login",
        method: "post",
        body: JSON.stringify(usuario),
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json"
        }
      };

      let status;
      fetch(opcoes.url, opcoes)
        .then(resposta => {
          status = resposta.status;
          return resposta.json();
        })
        .then(obj => {
          return {
            status,
            jwt: obj.jwt,
            usuario: obj.usuario
          };
        })
        .then(resultado => {
          this.$refs.modallogin.usuario = "";
          if (resultado.status == 200) {
            this.usuario = resultado.usuario;
            localStorage.setItem("meuJwt", resultado.jwt);
            localStorage.setItem(
              "meuUsuario",
              JSON.stringify(resultado.usuario)
            );
          } else {
            throw new Error("Usuario/ senha errados");
          }
        });
    },

    abrirmodallogin: function(){
        this.$refs.modallogin.abrirmodal()

    },

    registrarusuario: function(usuario) {
      let opcoes = {
        url: this.apiurl + "usuario/criar",
        method: "post",
        body: JSON.stringify(usuario),
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json"
        }
      };
      fetch(opcoes.url, opcoes)
        .then(resp => resp.json())
        .then(resp => {
          this.usuario = resp.usuario;
          localStorage.setItem("meuJwt", resp.jwt);
          localStorage.setItem("meuUsuario", JSON.stringify(resp.usuario));
          this.$refs.modalregistro.usuario = "";
        });
    }
  },

  components: {
    NavBar,
    ListagemItens,
    ModalLogin,
    ModalRegistro,
    Apresentacao
  }
};
</script>

<style>
  @import 'https://fonts.googleapis.com/icon?family=Material+Icons';
</style>



