<template>
    <form @submit.prevent="upload">
        <h1 class="upload-title">Upload your image</h1>
        <div class="image-upload">
            <input  @change="handleOnChange"  type="file"><br>
        </div>  
         <div id="preview">
            <img v-if="url" :src="url" @click="showModal()" class="img-preview" />
        </div> 
        <div class="nombre-input">
             <input @change="handleName" id="nombre" name="nombre" type="text">
        </div>  
        <div class="descripcion-input">
            <input @change="handleDescription" id="descripcion" name="descripcion" type="text">
        </div>  
        <div class="boton-upload">
          <button>Upload</button>
        </div>
    </form>
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
     
</template>

<script>
    export default{
        data: () => ({
            image: '',
            nombre: '',
            descripcion : '',
            url: null,
            modalShow:false
        }),
    

    methods: {
             showModal(ruta) {
                this.modalShow = true;
                //this.selectedImgPath = ruta   
                this.selectedImgPath = this.url    
            },
            hideModal() {
                this.modalShow = false; 
            },
            handleOnChange(e) {
                this.image = e.target.files[0]
                const file = e.target.files[0];
                this.url = URL.createObjectURL(file);
            },
            handleDescription(e) {
                this.descripcion = e.target.value
            },
            handleName(e) {
                this.nombre = e.target.value
            },
            upload() {
                const formData = new FormData
                formData.set('image', this.image)
                formData.set('nombre',this.nombre)
                formData.set('descripcion',this.descripcion)
                axios.post('/upload', formData)
                .then((response) => {
                        
                    })
                    .catch(function (error) {
                        console.log(error.response.data);
                    });
            }
        
        }
    }
</script>
