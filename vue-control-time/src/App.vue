<template>
  <div id="app">

    <Navbar/>

    <div class="container mt-5 mb-5">
      <router-view/>
    </div>

    <Footer/>

  </div>
</template>

<script>
  import Navbar from "@/components/Navbar";
  import Home from "@/components/Home";
  import Footer from "@/components/Footer";
  import {mdbRow} from "mdbvue";

  export default {
    components: {Navbar, Home, mdbRow, Footer}
  }

  document.title = 'Админ-панель';
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap');

$image-path: '~@/../mdb/mdbvue/img';
@import "~mdbvue/lib/scss/mdb-free.scss";
</style>
