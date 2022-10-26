<template >
    <body>
    <div class="gallery">
        <div class="box" v-for="imagen in imagenes" >
                <img :src="imagen.ruta"  @click="showModal(imagen.ruta)">  
                <h3>{{imagen.nombre}}</h3>
                <p>{{imagen.descripcion}}</p> 

                <p v-if="catalog == '1'" class="no-fav-p"><a class="no-fav imagen" :id="imagen.id_imagen" @click="favHandler" href="#">&#10084;  {{imagen.contador_fav}}</a></p>
               
                <div v-show="allowButton" class="load-more">
                    <button type="button" v-on:click="allowResponse(imagen.id_imagen)" class="btn btn-primary btn-sm">Allow</button> 
                </div>
        </div>  
    </div>
    <div v-show="moreExists" class="load-more">
        <button type="button" v-on:click="loadMore()" class="btn btn-primary btn-sm">Load more</button> 
    </div>
    <div v-if="modalShow" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <img :src='selectedImgPath'/>
            </div>
            <div class="vertical-center">
                <button @click="hideModal()" type="button">X</button>
            </div>
          </div>
        </div>
      </div>
     
    </body>
</template>
<script>
    let catalog = document.getElementById('top-nav-bar').getAttribute('catalog')
    let login = document.getElementById('top-nav-bar').getAttribute('login')
    export default {
        data: function () {
            return {
                imagenes: [],
                loading: true,
                modalShow: false,
                moreExists: false,
                nextPage : 0,
                catalog : catalog,
                login : login,
                allowButton : false,
                count : 0
            }
        },
        mounted() {
            this.loadImagenes();
            this.onUpdated();
        },
        methods: {
            loadImagenes: function () {
                if(this.catalog==1){
                    axios.get('/imagenes')
                        .then((response) => {
                            this.imagenes = response.data.data;
                            if(response.data.meta.current_page < response.data.meta.last_page){
                                this.moreExists = true;
                                this.nextPage = response.data.meta.current_page + 1
                                console.log(this.nextPage)
                            }else{
                                this.moreExists = false;
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else if(this.catalog==3){
                    axios.get('/allowImages')
                        .then((response) => {
                            this.imagenes = response.data.data
                            this.allowButton = true
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            showModal(ruta) {
                this.modalShow = true;
                this.selectedImgPath = ruta
                
                
               
            },
            hideModal() {
                this.modalShow = false; 
            },
            loadMore: function () {
                axios.get(`/imagenes?page=${this.nextPage}`)
                    .then((response) => {
                       
                        if(response.data.meta.current_page < response.data.meta.last_page){
                            this.moreExists = true;
                            this.nextPage = response.data.meta.current_page + 1
                        }else{
                            this.moreExists = false;
                        }
                        response.data.data.forEach(data =>{
                            this.imagenes.push(data);
                        })
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            allowResponse: function(id){
                console.log(id);
                const formData = new FormData
                formData.set('id', id)
                axios.post('/allowResponse', formData)
                .then((response) => {
                        console.log(`La imagen con id ${id} fue actualizada`)
                        location.href = '/moderator'
                    })
                    .catch(function (error) {
                        console.log(error.response.data);
                    });
                
            },
            onUpdated(){
            setTimeout(() =>
            this.likeProp()
            ,200)
            },
            favHandler(event){
                if(login==1){
                        let id = event.target.id
                        let likesNumber = parseInt(event.target.innerHTML.match(/\d+/)[0])
                        if(event.target.classList.contains("like")){
                            likesNumber -=1;
                            likesNumber.toString()
                            event.target.innerHTML = `&#10084;  ${likesNumber}`
                            event.target.classList.add("unlike")
                            event.target.classList.remove("like");
                            axios.post(`/dislikeHandler/${id}`,)
                            .then((response) => {
                                    console.log(`Dislike enviado`)
                                    console.log(response.data)
                                })
                            .catch(function (error) {
                                console.log(error.response.data);
                            });
                        }else if(event.target.classList.contains("unlike")){
                            likesNumber +=1;
                            likesNumber.toString()
                            event.target.innerHTML = `&#10084;  ${likesNumber}`
                            event.target.classList.add("like")
                            event.target.classList.remove("unlike");
                            axios.post(`/likeHandler/${id}`,)
                            .then((response) => {
                                    console.log(`Like enviado`)
                                    console.log(response.data)
                                })
                            .catch(function (error) {
                                console.log(error.response.data);
                            });
                        }
                    }
                },
            likeProp(){
                let count = document.getElementsByClassName("imagen").length
                let targetElement = 0
                let element = 0
                for(let i=0;i<count;i++){
                    targetElement = document.getElementsByClassName("imagen")[i].__vnode.props.id
                    console.log(targetElement)
                    axios.get(`/favSearch/${targetElement}`)
                        .then((response) => {
                            console.log(response.data)
                            if(response.data != 0){
                                element = document.getElementsByClassName("imagen")[i];
                                element.classList.add("like");
                            }else{
                                element = document.getElementsByClassName("imagen")[i];
                                element.classList.add("unlike");
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
                
            }
        }
    }
</script>