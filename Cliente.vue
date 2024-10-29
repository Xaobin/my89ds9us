
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = 
__   ___   _  ___ 
\ \ / | | | |/ _ \
 \ V /| |_| |  __/
  \_/  \__,_|\___|            
 =  =  =  =  =  =  -->
<script>
import { useStore } from '../store/store1';
    export default {
        computed: {
             setup() {
	            const storex = useStore();      
		        return { storex };
	        },
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
               nome:{title:'Nome', ordershow:2, visible:true},
               created_at:{title:'Criado', ordershow:3, visible:true},
               };
                return atitles;
            }
        },
        data() {
            return {
                urlBase: '/api/cliente',
                clientenome:'',
                transactStatus: '',
                transactDetails: {},
                clientedata:[],
                fileInputKey: 0,
                evtarget:'',
                selected:'id',
                inpSearchId:'',
                inpSearchNome:'',
                insearch:'false'
                
            }
        },
 /* . . . . . . . . . . . . . . . . . . . */
        methods: {
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){ 
    
    this.fileInputKey=this.storex.item.id;
 
 },
 /* . . . . . . . . . . . . . . . . . . . */
  resetMesgs(){
  
    this.storex.transact.status='';
    this.storex.transact.message='';

  },
 /* . . . . . . . . . . . . . . . . . . . */
searchh(){
    this.storex.transact.status='';
    this.storex.transact.message='';
    let vallSearch='';
    let urii="";

    if ((this.inpSearchId!='')&&(this.selected=='id')){
        let valss=window.btoa(this.selected+'&&&'+this.inpSearchId)
        vallSearch="?myfilter="+valss;
    }
    if ((this.inpSearchNome!='')&&(this.selected=='nome')){
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
              this.clientedata = response.data;
              this.insearch='true';
              console.log(this.datasearch);
          })
          .catch(errors => {
            alert("Não foi possível localizar");
              console.log(" - - - -");
              console.log(errors.response.data.message);
          })


},
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
  updateh() {
    this.storex.transact.status='';
    this.storex.transact.message='';
    this.clientenome=this.storex.item.nome; 
    
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('nome', this.clientenome);
 
    

    let url = this.urlBase + '/' + this.storex.item.id;
    //console.log(url);
    let config = {
        headers: {
           'Accept': 'application/json',
           'Authorization': this.token
        }
    }

    axios.post(url, formData, config)
    .then(response => {
        this.storex.transact.status = 'success';
        this.storex.transact.message = 'O registro foi atualizado!';
console.log("Enter response");
       //
        this.loadList();
    })
    .catch(errors => {
        
         this.storex.transact.status = 'error';
         this.storex.transact.message = errors.response.data.message;
       
        console.log("Enter errors");
        console.log(errors.response);
        
    })
},
 /* . . . . . . . . . . . . . . . . . . . */
  deleteh() {
    this.storex.transact.status='';
    this.storex.transact.message='';
     let formData = new FormData();
     formData.append('_method', 'delete')

     let url = this.urlBase + '/' + this.storex.item.id

     axios.post(url, formData)
         .then(response => {
             this.storex.transact.status = 'success';
             this.storex.transact.message = response.data.message;
             this.loadList(); 
         })
         .catch(errors => {
             this.storex.transact.status = 'error';
             this.storex.transact.message = errors.response.data.message;
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
              this.clientedata = response.data
              //console.log(this.clients)
          })
          .catch(errors => {
              console.log(errors)
          })
 },
/* . . . . . . . . . . . . . . . . . . . */

/* . . . . . . . . . . . . . . . . . . . */

/* . . . . . . . . . . . . . . . . . . . */
    saveh() {
        console.log(this.clientenome);

        let formData = new FormData();
        formData.append('name', this.clientenome)
        

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
             this.transactDetails = {
                 message:'Register ID: '+response.data.id
             }
             console.log("\n[add]The response Value: "+JSON.stringify(response))
              this.loadList()
        })
       .catch(errors => {
           this.transactStatus = 'error';
           this.transactDetails = {
               message: errors.response.data.message,
               dbdatas:errors.response.data.errors
          };
          console.log(errors);

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


 

</script>

<template>
    <div class="container">
    <div class="row justify-content-center">
    <div class="container-fluid col-md-8">

 <!--
                        | |    
 ___  ___  __ _ _ __ ___| |__  
/ __|/ _ \/ _` | '__/ __| '_ \ 
\__ |  __| (_| | | | (__| | | |
|___/\___|\__,_|_|  \___|_| |_|
         
 -->
 <!-- = = = = = = = =  =  =  = = [COMPONENT][Card:Search] -->


<card-cp title="Localizar">
    <template v-slot:content>
  
<select v-model="selected">
  <option value="id" enabled><small>Por ID</small></option>
  <option value="name"><small>Por nome</small></option>
</select>
    
    <input type="number"  class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-if="selected=='id'" v-model="inpSearchId">
     <input type="text" class="form-control" id="inputname" aria-describedby="nameHelp"
        placeholder="name of client" v-if="selected=='name'" v-model="inpSearchNome">
     <button class="btn btn-primary btn-sm" @click="searchh()">Localizar</button>
   
    </template>
    </card-cp>
     <button class="btn btn-primary" v-if="insearch=='true'" @click="loadList()">Fechar pesquisa</button>



 <!-- = = = = = = = =  =  [End of Card:Search] = -->
<!--
           _     _ 
          | |   | |
  __ _  __| | __| |
 / _` |/ _` |/ _` |
| (_| | (_| | (_| |
 \__,_|\__,_|\__,_|
                 
-->
<!-- = = = = = = = =  =  =[COMPONENT][Modal:Add]-->
<dmodal-cp modalname="modalAdd" title="Adicionar cliente">
<template v-slot:alerts> 
<alert-cp stll="success" :details="transactDetails"
title="Registrado com sucesso!
v-if="transactStatus == 'added'"></alert-cp>
<alert-cp stll="danger" :details="transactDetails"
title="Erro no registro - consulte o administrador do sistema"
v-if="transactStatus == 'error'"></alert-cp>
</template>

       <template v-slot:content> 
       
       <div class="form-group">
    <input-cp title="nome do cliente" id="newName" id-help="newNameHelp"
        text-help="Informe o nome do cliente">
    <input type="text" class="form-control" id="newName" aria-describedby="newNameHelp"
           placeholder="nome do cliente" v-model="clientenome">
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
       _               
      (_)              
__   ___  _____      __
\ \ / | |/ _ \ \ /\ / /
 \ V /| |  __/\ V  V / 
  \_/ |_|\___| \_/\_/  
                  
-->
<dmodal-cp modalname="modalView" title="Visualizar cliente">
       <template v-slot:alerts></template>
       <template v-slot:content> 
       <li> ID: {{storex.item.id}}</li>
       <li> Nome: {{storex.item.nome}}</li>
       <li> Criado em: {{storex.item.created_at}}</li>
       <br>
       </template>
       <template v-slot:footer>
       </template>

   </dmodal-cp>
<!--
                 _       _       
                | |     | |      
 _   _ _ __   __| | __ _| |_ ___ 
| | | | '_ \ / _` |/ _` | __/ _ \
| |_| | |_) | (_| | (_| | ||  __/
 \__,_| .__/ \__,_|\__,_|\__\___|
      | |                        
      |_|   
-->
 <dmodal-cp modalname="modalUpd" title="Atualizar cliente">
  <template v-slot:alerts>
    <alert-cp stll="success" title="Atualização feita com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="erro na atualização - consulte o administrador do sistema" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>
  </template>

       <template v-slot:content> 
       {{setUpdValues()}} 
     <div class="form-group">
        
        <input-cp title="Nome do cliente" id="updNamex" id-help="updNameHelp" text-Help="Informe o nome do cliente (Atualização)">
    
        <input type="text" class="form-control" id="updName" v-model="storex.item.nome" aria-describedby="updNameHelp">
        </input-cp> 
        </div>
    
        
       </template>

       <template v-slot:footer>
        &nbsp;<button type="button" class="btn btn-primary" @click="updateh()">Atualizar</button>
       </template>

   </dmodal-cp>
<!--
     _      _      _       
    | |    | |    | |      
  __| | ___| | ___| |_ ___ 
 / _` |/ _ | |/ _ | __/ _ \
| (_| |  __| |  __| ||  __/
 \__,_|\___|_|\___|\__\___|
-->
<dmodal-cp modalname="modalDel" title="Ver cliente">
       <template v-slot:alerts>
           <alert-cp stll="success" title="Excluído com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="Erro ao excluir - consulte o administrador do sistema" :details="storex.transact" v-if="storex.transact.status == 'error'"></alert-cp>
       </template>
       <template v-slot:content> 
       
       <h4>Excluir cliente com o seguinte conteúdo</h4><hr>
       <li> ID: {{storex.item.id}}</li>
       <li> Name: {{storex.item.nome}}</li>
       <li> Criado em: {{storex.item.created_at}}</li>
       <br>
       </template>
       <template v-slot:footer>
         &nbsp;<button type="button" class="btn btn-danger" @click="deleteh()" v-if="storex.transact.status != 'success'">Confirma</button>
       </template>

   </dmodal-cp>










<!--
 _ _     _   
| (_)   | |  
| |_ ___| |_ 
| | / __| __|
| | \__ | |_ 
|_|_|___/\__|
       
-->
<!-- = = = = = = = =  =  =[COMPONENT][Card:List]  -->
<card-cp title="Lista de clientes">

    <template v-slot:content>
     <table-cp :dbdatas="clientedata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView'}"
               :ddel="{visible:true, dataTarget:'modalDel'}"
               :dupd="{visible:true, dataTarget:'modalUpd'}"
               :config="{title:'NotNullable', amountcolls: 1, refrow:'nullable',refname:'nullable',visible:true, imagefield:'Image',funvisible:false}"
     ></table-cp>
      </template>

      <template v-slot:footer>
      <button type="button" class="btn btn-primary btn-sm float-right"
      onclick="document.getElementById('modalAdd').style.display='block'">Adicionar</button>


    </template>

    </card-cp>
<!-- = = = = = = = =  =  = [End of Card:List] = -->


</div>
</div>
</div>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
</template>
