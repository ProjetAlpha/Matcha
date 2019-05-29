<template>
  <div>
    <h1>Hello </h1>
    <div>
      <h1>{{name}}</h1>
    </div>
    <div>
      <h1>{{lastname}}</h1>
    </div>
    <button @click="setTitle" class="waves-effect btn">Change Names</button>
  </div>
</template>

<script>
    export default{
        data(){
            return {
                names:this.namesArray,
                data:['yolo'],
                name:'John',
                lastname: 'Doh'
            }
        },
        methods: {
            rand(length){
                var result           = '';
                var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < length; i++ ) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                this.name = result;
                this.lastname = result;
            },
            setTitle(event){
                console.log(event.target);
                //event.target.className = "waves-effect waves-light purple darken-4 btn";
                this.rand(15);
                this.rand(15);
            }
        }
    }
</script>
