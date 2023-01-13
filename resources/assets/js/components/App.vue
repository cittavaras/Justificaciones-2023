<template>
  <div class="outer">
    <div class="container">
      <LeftNav class="leftnav"></LeftNav>
      <TopNav class="topnav"></TopNav>
      <Main class="main"></Main>
      <Footer class="footer"></Footer>
      <Logo class="logo"></Logo>
    </div>
  </div>
</template>

<script>
import LeftNav from './LeftNav.vue';
import TopNav from './TopNav.vue';
import Main from './Main.vue';
import Footer from './Footer.vue';
import Logo from './Logo.vue';
export default {
  name: 'App',
  components: {
    LeftNav,
    TopNav,
    Main,
    Footer,
    Logo,
  },
};
</script>

<style>
/* * {
  margin: 0;
  padding: 0;
} */

#app {
  /* font-family: Avenir, Helvetica, Arial, sans-serif; */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.leftnav {
  grid-area: leftnav;
}
.main {
  grid-area: main;
}
.topnav {
  grid-area: topnav;
}
.footer {
  grid-area: footer;
}
.logo {
  grid-area: logo;
}

.container {
  display: grid;
  grid-template-columns: 250px auto;
  grid-template-rows: 50px auto 50px;
  grid-template-areas:
    'leftnav topnav'
    'leftnav main'
    'logo footer';
  width: 70vw;
  height: 100vh;
}

.outer {
  background-color: #3d3d3d;
}
</style>
