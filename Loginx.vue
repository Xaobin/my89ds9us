<script>
  export default {
        props:['csrf_token'],
        data(){               
            return {
                email:'',
                password:'' 
            };
        },
         methods:{
            login(e){
           
                let url="/api/login";
                let url2="login";
                let homeurl="/sys/v1/home";
                let tokk='';

                var details = {
                    'email': this.email,
                    'password': this.password
                };

                var formBody = [];
                for (var property in details) {
                var encodedKey = encodeURIComponent(property);
                var encodedValue = encodeURIComponent(details[property]);
                formBody.push(encodedKey + "=" + encodedValue);
                }
                formBody = formBody.join("&");

                let confs = {   
                        method: 'POST',
                         headers: {
                     'Content-Type': 'application/x-www-form-urlencoded'
                         },
                        body: formBody
                    }
                    
                     fetch(url,confs) 
                     .then( response=>response.json()) 
                     .then(data=>{
                        if (data.token){ 
                            console.log("Dados do data: ");
                            console.log(data);
                            
                            document.cookie = 'token='+data.token+';SameSite=Lax';
                            document.cookie = 'name='+data.nome+';SameSite=Lax';
                            sessionStorage.setItem("token", data.token); 
                        }
                        e.target.submit(); 
                        window.location.href = homeurl;
                     })

     },
        createVar(){
              //  document.cookie="token=; path=/;";
              //  document.cookie="checks=; path=/;";
              //  document.cookie="name=; path=/;";   



        }    
    },
    mounted() { 
            this.createVar();
            
        }
  }

  
</script>
<template>

    <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
        <div class="card-header">Login</div>
    
        <div class="card-body">
          
         <form method="POST" action="" enctype="application/x-www-form-urlencoded" @submit.prevent="login($event)">

        <div class="row mb-3">
         <input type="hidden" name="_token" :value="csrf_token">
         
            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>
          <div class="col-md-6">
            <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus v-model="email">
          </div>                       
        
        </div>
 
        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="password">
            </div>
        </div>
  
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>
            </div>
        </div>
 
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
                <a class="btn btn-link" href="#">Forgot password</a>
            </div>
        </div>
  
      </form>
 
                </div>
            </div>
        </div>
    </div>
    </div>
    
</template>