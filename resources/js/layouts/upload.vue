<template>
    <form @submit.prevent="upload">
        <h1 class="upload-title">Upload your image</h1>
        <div class="image-upload">
            <input  @change="handleOnChange" type="file"><br>
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
</template>

<script>
    export default{
        data: () => ({
            image: '',
            nombre: '',
            descripcion : ''
        }),
    

    methods: {
            handleOnChange(e) {
                this.image = e.target.files[0]
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
