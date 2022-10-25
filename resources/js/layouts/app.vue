<template >
    <body>
    <div class="gallery">
        <div class="box" v-for="imagen in imagenes" >
                <img :src="imagen.ruta"  @click="showModal(imagen.ruta)">  
                <h3>{{imagen.nombre}}</h3>
                <p>{{imagen.descripcion}}</p> 
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
    export default {
        data: function () {
            return {
                imagenes: [],
                loading: true,
                modalShow: false,
                moreExists: false,
                nextPage : 0,
                catalog : catalog,
                allowButton : false,
            }
        },
        mounted() {
            this.loadImagenes();
        },
        methods: {
            loadImagenes: function () {
                if(this.catalog==1){
                    axios.get('/api/imagenes')
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
                    axios.get('/api/allowImages')
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
                axios.get(`/api/imagenes?page=${this.nextPage}`)
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
                
            }
        }
    }
</script>