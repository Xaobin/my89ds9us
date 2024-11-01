
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
        computed: {
            token() {

                 let token = document.cookie.split(';').find(ind => {
                    return ind.includes('token=')
                })

                token = token.split('=')[1];
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
 /* . . . . . . . . . . . . . . . . . . . */
        methods: {
 /* . . . . . . . . . . . . . . . . . . . */
        avaVal(){
            this.loadList();
            this.storex.setDBData(this.marcasdata);
            console.log(this.storex.dbdata);

        },
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
                console.log(" - - - -");
              console.log(this.marcasdata);
          })
          .catch(errors => {
            alert("Não foi localizado");
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
    this.nomemarca=this.storex.item.Nome; 
    
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('nome', this.nomemarca);
 
    if(this.fileImage[0]) {
        formData.append('imagem', this.fileImage[0]);
        this.resetValues();
    }

    let url = this.urlBase + '/' + this.storex.item.ID

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

     let url = this.urlBase + '/' + this.storex.item.ID

     axios.post(url, formData)
         .then(response => {
             //this.transactStatus = 'success';
             this.storex.setStatus('success');
             this.storex.transact.msg = response.data.msg;
             this.loadList(); 
         })
         .catch(errors => {
            // this.transactStatus = 'error';
             this.storex.setStatus('error');
             this.storex.transact.msg = errors.response.data.msg;
         })
        

  },
 /* . . . . . . . . . . . . . . . . . . . */
  loadList() {
    this.insearch='false';
    this.storex.setDBData([]);
    //this.transactStatus='';
      let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      //console.log("List Loaded");
      axios.get(this.urlBase, config)
          .then(response => {
              this.marcasdata = response.data;
              this.storex.setDBData(response.data);
             
              
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
        formData.append('nome', this.nomemarca)
        formData.append('imagem', this.fileImage[0])

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
                 msg:'Registro ID: '+response.data.id
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
           // this.marcasdata=this.storex.dbdata;
           // console.log('storex data:');
           // console.log(this.storex.dbdata);

        }
        //created(){
        //    this.loadList();
       // }
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


<card-cp title="Busca por marcas">
    <template v-slot:content>

 <small> 
<select v-model="selected">
  <option value="id" enabled>Search by Id</option>
  <option value="name">Search by Name</option>
</select>
    </small>
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
<dmodal-cp modalname="modalBrandAdd" title="Adicionar marca">
<template v-slot:alerts> 
<alert-cp stll="success" :details="detalhesTransact"
title="Registration done successfully"
v-if="transactStatus == 'added'"></alert-cp>
<alert-cp stll="danger" :details="detalhesTransact"
title="Error when trying to register the brand"
v-if="transactStatus == 'error'"></alert-cp>
</template>

       <template v-slot:content> 
       <div class="form-group">
    <input-cp title="Nome da marca" id="newName" id-help="newNameHelp"
        text-help="Informe o nome da marca">
    <input type="text" class="form-control" id="newName" aria-describedby="newNameHelp"
           placeholder="Nome da marca" v-model="nomemarca">
    </input-cp> 
    </div>

     <div class="form-group"> <!-- = =[Input:Image] = = -->
    <input-cp title="Image" id="newImage" id-help="newImageHelp"
    text-help="Seleciona a imagem no formato PNG">
    <input type="file" class="form-control-file" id="newImage" aria-describedby="newImageHelp" placeholder="Selecione a imagem"
    @change="loadImage($event)">
    </input-cp> 
    </div>
    </template>

      <template v-slot:footer>
        <button type="button" class="btn btn-primary"
        @click="saveh()">Salvar</button>
        </template>
</dmodal-cp>

    <!-- = = = = = = = =  =  [End of Modal] -->

<!--
MODAL VIEW
-->
<dmodal-cp modalname="modalView" title="Visualizando a marca">
       <template v-slot:alerts></template>
       <template v-slot:content> 
       <li> ID: {{storex.item.ID}}</li>
       <li> Nome: {{storex.item.Nome}}</li>
       <li> Imagem: <img :src="'/'+storex.item.Imagem" width="30" height="30"></li>
       <li> Criado em: {{storex.item['Criado em']}}</li>
       <br>
       </template>
       <template v-slot:footer>
       </template>

   </dmodal-cp>
<!--
MODAL UPDATE
-->
 <dmodal-cp modalname="modalUpd" title="Atualizando a marca">
  <template v-slot:alerts>
    <alert-cp stll="success" title="Atualização realizada com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="erro na atualização" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>
  </template>

       <template v-slot:content> 
       {{setUpdValues()}}
     <div class="form-group">
        
        <input-cp title="Nome da marca" id="updNomex" id-help="updNomeHelp" text-Help="Informe o nome da marca (Update)">
    
        <input type="text" class="form-control" id="updNome" v-model="storex.item.Nome" aria-describedby="updNomeHelp">
        </input-cp> 
        </div>
    
        <div class="form-group">
        <input-cp title="Image" id="updImage" id-help="updImageHelp" text-Help="Selecione uma imagem no formato PNG">
        <input type="file" class="form-control-file" 
        id="updNome" :key="fileInputKey"
        aria-describedby="updImageHelp" placeholder="Selecione a imagem" @change="loadImage($event)">
        </input-cp>
        </div>
       </template>

       <template v-slot:footer>&nbsp;
       <button type="button" class="btn btn-secondary" @click="resetValues()">Limpar dados</button>&nbsp;
        <button type="button" class="btn btn-primary" @click="updateh()">Atualizar</button>
       </template>

   </dmodal-cp>
<!--
MODAL DELETE
-->
<dmodal-cp modalname="modalDel" title="Visualizando a marca">
       <template v-slot:alerts>
         <alert-cp stll="success" title="Excluído com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'"></alert-cp>
         <alert-cp stll="danger" title="Erro no processo de exclusão" :details="storex.transact" v-if="storex.transact.status == 'error'"></alert-cp>
       </template>
       <template v-slot:content> 
       <h4>Prestes a excluir a marca com o seguinte conteúdo:</h4><hr>
       <li> ID: {{storex.item.ID}}</li>
       <li> Nome: {{storex.item.Nome}}</li>
       <li> Imagem: <img :src="'/'+storex.item.Imagem" width="30" height="30"></li>
       <li> Data criação: {{storex.item['Criado em']}}</li>
       <br>
       </template>
       <template v-slot:footer>
         <button type="button" class="btn btn-danger" @click="deleteh()" v-if="storex.transact.status != 'success'">Confirma</button>
       </template>

   </dmodal-cp>










<!--
LIST
-->
<!-- = = = = = = = =  =  =[COMPONENT][Card:List]  -->
<card-cp title="Lista de marcas">

    <template v-slot:content>
     <table-cp :dbdatas="marcasdata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView',title:'Ver'}"
               :ddel="{visible:true, dataTarget:'modalDel',title:'Excluir'}"
               :dupd="{visible:true, dataTarget:'modalUpd',title:'Atualizar'}"
               :config="{title:'NotNullable', amountcolls: 1, refrow:'nullable',refname:'nullable',visible:true, imagefield:'Imagem',funvisible:false}"
     ></table-cp>
      </template>

      <template v-slot:footer>
      <button type="button" class="btn btn-primary btn-sm float-right"
      onclick="document.getElementById('modalBrandAdd').style.display='block'">Adicionar</button>


    </template>

    </card-cp>
<!-- = = = = = = = =  =  = [End of Card:List] = -->


</div>
</div>
</div>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
</template>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->



