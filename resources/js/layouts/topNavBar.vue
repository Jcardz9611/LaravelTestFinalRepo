<template>
    <header>
        <h1>JinterApp</h1>
        <nav>
            <ul class="nav__links">
                <li v-if="catalog !== '1'"><a href="/">Home</a></li>
                <li v-if="catalog !== '2'"><a href="/upload">Upload</a></li>
                <li v-if="catalog !== '4'" ><a href="/favCatalog">Favorites</a></li>
                <li v-if="role === '1' && catalog !='3'"><a href="/moderator">Moderator</a></li>
                <li v-if="login === '0'"><a href="/login">Login</a></li>
                <li v-if="login === '0'"><a href="/register">Register</a></li>
                <li v-if="login === '1'"><a @click="logout">Logout</a></li>
                
            </ul>
        </nav>
    </header>
</template>
<script>
let catalog = document.getElementById('top-nav-bar').getAttribute('catalog')
let login = document.getElementById('top-nav-bar').getAttribute('login')
let role = document.getElementById('top-nav-bar').getAttribute('role')
console.log(catalog)
export default {
  data() {
    return {
      catalog: catalog,
      login : login,
      role : role
    }
  },
   methods: {
            logout() {
                axios.post('/logout')
                    .then(() => location.href = '/')
            }
        }
}
</script>