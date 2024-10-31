
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  = 
VUE
 =  =  =  =  =  =  -->
<script>
import { useStore } from '../store/store1'
    export default {
        setup() {
	            const storex = useStore();      
		        return { storex };
	        },
        computed: {
            token() {

                 let token = document.cookie.split(';').find(ind => {
                    return ind.includes('token=')
                })

                token = token.split('=')[1]
                token = 'Bearer ' + token

                return token
            },
           titlesCP(){
                 let atitles={ id:{title:'ID', ordershow:1, visible:true},
               nome:{title:'Nome', ordershow:2,visible:true},
               imagem:{title:'Imagem', ordershow:3,visible:true},
               created_at:{title:'Criado em', ordershow:4,visible:true},
               };
                return atitles;
            }
        },
        data() {
            return {
                urlBase: '/api/marca',
                nomemarca:'',
                fileImage: [],
                transactStatus: '',
                detalhesTransact: {},
                marcasdata:[],
                fileInputKey: 0,
                evtarget:'',
                selected:'Id',
                inpSearchId:'',
                inpSearchNome:'',
                datasearch:[],
                insearch:'false'
                
            }
        },
 /* . . . . . . . . . . . . . . . . . . . */
        methods: {
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){
   //if (this.$refs.updNome!=undefined){
     // console.log(this.$refs.updNome.value);
    //this.$refs.updNome.value=this.storex.item.nome;   
    this.fileInputKey=this.storex.item.id;
  // }
 },
 /* . . . . . . . . . . . . . . . . . . . */
  resetValues(){
  // this.$refs.updNome.value='';
   this.evtarget.value='';
    //this.fileInputKey=-1;
    console.log(this.fileImage[0]);
    //if (this.$refs.updNome!=undefined){
      console.log(this.storex.item.nome);
   //}
   //this.$refs.updNome.value='';
  },
 /* . . . . . . . . . . . . . . . . . . . */
searchh(){
    this.storex.setStatus('');
    this.storex.setMsg('');
    let vallSearch='';
    let urii="";

    if ((this.inpSearchId!='')&&(this.selected=='id')){
        let valss=window.btoa(this.selected+'&&&'+this.inpSearchId)
        vallSearch="?myfilter="+valss;
    }
    if ((this.inpSearchNome!='')&&(this.selected=='name')){
        let valss=window.btoa(this.selected+'&&&'+this.inpSearchNome)
        vallSearch="?myfilter="+valss;
    }
    // - - - - - - - - - - - - - - - - - -
    urii=this.urlBase+vallSearch;
   let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      //console.log("List Loaded");
      axios.get(urii, config)
          .then(response => {
              this.marcasdata = response.data;
             // this.datasearch = response.data;
              this.insearch='true';
              //console.log(this.datasearch);
          })
          .catch(errors => {
            alert("the resource not found");
              console.log(" - - - -");
              console.log(errors.response.data.msg);
          })


},
 /* . . . . . . . . . . . . . . . . . . . */
   viewh(){
   
    let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }
               // console.log("Wheel:"+this.wheel);
                axios.get(this.urlBase+"/", config)
                    .then(response => {
                        console.log(">>>"+response.data);
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
        
   },
 /* . . . . . . . . . . . . . . . . . . . */
  updateh() {
    this.storex.setStatus('');
    this.storex.setMsg('');
    this.nomemarca=this.storex.item.nome; 
    
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('name', this.nomemarca);
 
    if(this.fileImage[0]) {
        formData.append('image', this.fileImage[0]);
        this.resetValues();
    }

    let url = this.urlBase + '/' + this.storex.item.id

    let config = {
        headers: {
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
            'Authorization': this.token
        }
    }

    axios.post(url, formData, config)
    .then(response => {
        this.storex.setStatus('success');
        this.storex.setMsg('O registro foi atualizado');
console.log("Enter response");
       //
        this.loadList();
          // this.storex.item.nome=this.nomemarca;
            //this.fileInputKey=0;
    })
    .catch(errors => {
        
         this.storex.setStatus('error');
         this.storex.setMsg(errors.response.data.msg);
       
        console.log("Erros Relatados");
      
        
    })
},
 /* . . . . . . . . . . . . . . . . . . . */
  deleteh() {
    this.storex.setStatus('');
    this.storex.setMsg('');
     let formData = new FormData();
     formData.append('_method', 'delete')

     let url = this.urlBase + '/' + this.storex.item.id

     axios.post(url, formData)
         .then(response => {
             this.storex.setStatus('success');
             this.storex.transact.msg = response.data.msg;
             this.loadList(); 
         })
         .catch(errors => {
             this.storex.setStatus('error');
             this.storex.transact.msg = errors.response.data.msg;
         })
        

  },
 /* . . . . . . . . . . . . . . . . . . . */
  loadList() {
    this.insearch='false';
      let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      //console.log("List Loaded");
      axios.get(this.urlBase, config)
          .then(response => {
              this.marcasdata = response.data
              //console.log(this.brands)
          })
          .catch(errors => {
              console.log(errors)
          })
 },
/* . . . . . . . . . . . . . . . . . . . */
            loadImage(e) {
                // e.target.value='';
                this.evtarget=e.target;
                this.fileImage = e.target.files;
               
               //console.log(e.target.files);
            },
/* . . . . . . . . . . . . . . . . . . . */

/* . . . . . . . . . . . . . . . . . . . */
    saveh() {
        console.log(this.nomemarca, this.fileImage[0])

        let formData = new FormData();
        formData.append('name', this.nomemarca)
        formData.append('image', this.fileImage[0])

        let config = {
            headers: {                    /* ___1___ */
           'Content-Type': 'multipart/form-data',
           'Accept': 'application/json',
           'Authorization': this.token
           }
        }

        axios.post(this.urlBase, formData, config)
         .then(response => {
             this.transactStatus = 'added'      /* ___3___ */
             this.detalhesTransact = {
                 msg:'Register ID: '+response.data.id
             }
             console.log("\n[add]The response Value: "+JSON.stringify(response))
              this.loadList()
        })
       .catch(errors => {
           this.transactStatus = 'error'
           this.detalhesTransact = {
               msg: errors.response.data.msg,
               dbdatas:errors.response.data.errors

          }

        })

    }
/* . . . . . . . . . . . . . . . . . . . */
        },
/* . . . . . . . . . . . . . . . . . . . */
        mounted() {  /* ___5___ */
            this.loadList();
            

        }
    }
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */

/*
 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    EXPLICAÇÃO
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

___1___ - Adiciona o token de autorização  no cabeçaho da Requisição
___2___ - Utilização da Biblioteca Axios, já disponível em js, substitui
a outra também default, chamada FETCH
___3___ - transactStatus - se a requisição do axios for true, retorna added,
senão error, depois o resultado de retorno é usado no component alert - usando
um v-if.
___4___ - detalhesTransact - valor da props details do componente alert, é o
resultado da requisição feita no axios. Uso do Bind ":". Dentro do componente
alert possui um props chamado details, onde é chamado: details.data.msg.
Também tem o details.data.errors, onde os erros são listados usando um v-for
___5___ - Atributo mounted - é usado quando os componentes são carregados,
quando estiverem montados(mounted), é executado uma ação: no caso: loadList



- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
      EXPLANATION
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

___1___ - Adds the authorization token to the Request header
___2___ - Use of the Axios Library, already available in js, replaces
the other also default, called FETCH
___3___ - transactStatus - if the axios request is true, returns added,
otherwise error, then the return result is used in component alert - using
a v-se.
___4___ - detalhesTransact - value of the props details of the alert component, it is the
result of the request made in axios. Use of Bind ":". inside the component
alert has a props called details, where it is called: details.data.msg.
There is also details.data.errors, where errors are listed using a v-for
___5___ - mounted attribute - is used when components are loaded,
when they are mounted, an action is executed: in this case: loadList

*/


</script>





<template>
    <div class="container">
    <div class="row justify-content-center">
    <div class="container-fluid col-md-8">


 <!-- = = = = = = = =  =  =  = = [COMPONENT][Card:Search] -->


<card-cp title="Search for brands">
    <template v-slot:content>
  
<select v-model="selected">
  <option value="id" enabled><small>Search by Id</small></option>
  <option value="name"><small>Search by Name</small></option>
</select>
    
    <input type="number"  class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-if="selected=='id'" v-model="inpSearchId">
     <input type="text" class="form-control" id="inputname" aria-describedby="nameHelp"
        placeholder="name of brand" v-if="selected=='name'" v-model="inpSearchNome">
     <button class="btn btn-primary btn-sm" @click="searchh()">Search</button>
   
    </template>
    </card-cp>
     <button class="btn btn-primary" v-if="insearch=='true'" @click="loadList()">
      Close Search  
     </button>



 <!-- = = = = = = = =  =  [End of Card:Search] = -->

<!-- = = = = = = = =  =  =[COMPONENT][Modal:Add]-->
<dmodal-cp modalname="modalBrandAdd" title="Add brand">
<template slot="alerts"> 
<alert-cp stll="success" :details="detalhesTransact"
title="Registration done successfully"
v-if="transactStatus == 'added'"></alert-cp>
<alert-cp stll="danger" :details="detalhesTransact"
title="Error when trying to register the brand"
v-if="transactStatus == 'error'"></alert-cp>
</template>

       <template slot="content"> 
       <div class="form-group">
    <input-cp title="name of brand" id="newName" id-help="newNameHelp"
        text-help="Inform the name of brand">
    <input type="text" class="form-control" id="newName" aria-describedby="newNameHelp"
           placeholder="name of brand" v-model="nomemarca">
    </input-cp> 
    </div>

     <div class="form-group"> <!-- = =[Input:Image] = = -->
    <input-cp title="Image" id="newImage" id-help="newImageHelp"
    text-help="Select the image in format PNG">
    <input type="file" class="form-control-file" id="newImage" aria-describedby="newImageHelp" placeholder="Select a Image"
    @change="loadImage($event)">
    </input-cp> 
    </div>
    </template>

      <template slot="footer">
        <button type="button" class="btn btn-primary"
        @click="saveh()">save</button>
        </template>
</dmodal-cp>

    <!-- = = = = = = = =  =  [End of Modal] -->

<!--
MODAL VIEW
-->
<dmodal-cp modalname="modalView" title="View brand">
       <template slot="alerts"></template>
       <template slot="content"> 
       <li> ID: {{storex.item.id}}</li>
       <li> Name: {{storex.item.nome}}</li>
       <li> Image: <img :src="'/'+storex.item.image" width="30" height="30"></li>
       <li> Created: {{storex.item.created_at}}</li>
       <br>
       </template>
       <template slot="footer">
       </template>

   </dmodal-cp>
<!--
MODAL UPDATE
-->
 <dmodal-cp modalname="modalUpd" title="Update brand">
  <template slot="alerts">
    <alert-cp stll="success" title="Transaction performed with success" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="error in Transaction" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>
  </template>

       <template slot="content"> 
       {{setUpdValues()}}
     <div class="form-group">
        
        <input-cp title="Name of brand" id="updNomex" id-help="updNomeHelp" text-Help="Inform the Name of brand (Update)">
    
        <input type="text" class="form-control" id="updNome" v-model="storex.item.nome" aria-describedby="updNomeHelp">
        </input-cp> 
        </div>
    
        <div class="form-group">
        <input-cp title="Image" id="updImage" id-help="updImageHelp" text-Help="Select  a Image no formato PNG">
        <input type="file" class="form-control-file" 
        id="updNome" :key="fileInputKey"
        aria-describedby="updImageHelp" placeholder="Select a Image" @change="loadImage($event)">
        </input-cp>
        </div>
       </template>

       <template slot="footer">
       <button type="button" class="btn btn-secondary" @click="resetValues()">Clear</button>
        <button type="button" class="btn btn-primary" @click="updateh()">Update</button>
       </template>

   </dmodal-cp>
<!--
MODAL DELETE
-->
<dmodal-cp modalname="modalDel" title="View brand">
       <template slot="alerts">
           <alert-cp stll="success" title="Deleted  with success" :details="storex.transact" v-if="storex.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="error to delete proccess" :details="storex.transact" v-if="storex.transact.status == 'error'"></alert-cp>
       </template>
       <template slot="content"> 
       <h4>Delete the Brand with follow content</h4><hr>
       <li> ID: {{storex.item.id}}</li>
       <li> Name: {{storex.item.nome}}</li>
       <li> Image: <img :src="'/'+storex.item.image" width="30" height="30"></li>
       <li> Created: {{storex.item.created_at}}</li>
       <br>
       </template>
       <template slot="footer">
         <button type="button" class="btn btn-danger" @click="deleteh()" v-if="storex.transact.status != 'success'">Confirm</button>
       </template>

   </dmodal-cp>










<!--
LIST
-->
<!-- = = = = = = = =  =  =[COMPONENT][Card:List]  -->
<card-cp title="List of brands">

    <template slot="content">
     <table-cp :dbdatas="marcasdata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView',title:'Ver'}"
               :ddel="{visible:true, dataTarget:'modalDel',title:'Excluir'}"
               :dupd="{visible:true, dataTarget:'modalUpd',title:'Atualizar'}"
               :config="{title:'NotNullable', amountcolls: 1, refrow:'nullable',refname:'nullable',visible:true, imagefield:'Image',funvisible:false}"
     ></table-cp>
      </template>

      <template slot="footer">
      <button type="button" class="btn btn-primary btn-sm float-right"
      onclick="document.getElementById('modalBrandAdd').style.display='block'">Add</button>


    </template>

    </card-cp>
<!-- = = = = = = = =  =  = [End of Card:List] = -->


</div>
</div>
</div>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
</template>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->



