<template>
    <header>
        <h1>JinterApp</h1>
        <nav>
            <ul class="nav__links">
                <li v-if="catalog === '1'"><a href="/upload">Upload</a></li>
                <li v-if="catalog === '2'"><a href="/">Home</a></li>
                <li><a href="#">Favorites</a></li>
                <li><a href="#">Upload</a></li>
            </ul>
        </nav>
    </header>
</template>
<script>
let catalog = document.getElementById('top-nav-bar').getAttribute('catalog')
console.log(catalog)
export default {
  data() {
    return {
      catalog: catalog
    }
  },
  methods: {
            logout() {
                axios.post('/logout').then(response => {
                    this.$router.push("/login")

                }).catch(error => {
                    location.reload();
                });
            }
 }
}
</script>