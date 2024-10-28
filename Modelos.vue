<script>
/*
id, marca_id, nome, imagem, portas, assentos. air_bag, abs, created_at, updated_at
*/
import { useStore } from '../store/store1'
    export default {
        setup() {
	            const storex = useStore();      
		        return { storex };
	        },
        computed: {
/* . . . . . . . . . . . . . . . . . . . */            
            token() {

                 let token = document.cookie.split(';').find(ind => {
                    return ind.includes('token=')
                })

                token = token.split('=')[1]
                token = 'Bearer ' + token

                return token
            },
/* . . . . . . . . . . . . . . . . . . . */        
      titlesCP(){
       let atitles={ id:{title:'ID', ordershow:1, visible:true},
       nome:{title:'Nome', ordershow:2,visible:true},
       imagem:{title:'Imagem', ordershow:3,visible:true},
       portas:{title:'Portas', ordershow:4, visible:true},
       assentos:{title:'Assentos', ordershow:5, visible:false},
       air_bag:{title:'Air Bag', ordershow:6, visible:false},
       abs:{title:'ABS', ordershow:7, visible:false},
       ref_marca:{title:'Marca', ordershow:8,visible:true},
       marca_id:{title:'Marca_ID', ordershow:9, visible:false}
       }; 
        return atitles;
       },
/* . . . . . . . . . . . . . . . . . . . */      
    refMarcasCP(){
        let neovar=[];
        Object.entries(this.refMarcaVals).forEach(jobj => {
            let tmpv=[];
            const pn = Object.keys(jobj);
            tmpv[0]=jobj['1'].id;
            tmpv[1]=jobj['1'].marca;
            neovar.push(tmpv);
        });
        return neovar;
    }
 /* . . . . . . . . . . . . . . . . . . . */           
        },
 /* . . . . . . . . . . . . . . . . . . . */         
        data() {
            return {
                urlBase: '/api/modelo',
                nomemodelo:'',
                portasmodelo:0,
                assentosmodelo:0,
                airbagmodelo:0,
                absmodelo:0,
                fileImagem: [],
                amountReq: 0,
                refMarcaVals: {},
                modelosdata:[],
                refNome:0,
                fileInputKey: 0,
                evtarget:'',
                selected:'id',
                opsearch:false,
                
               // datasearch:[],
              //  insearch:'false'
                
            }
        },
 /* . . . . . . . . . . . . . . . . . . . */
        methods: {
            resetForm(){
                this.nomemodelo=''; this.portasmodelo=0;
                this.assentosmodelo=0; this.absmodelo=0;
                this.fileImagem=[]; this.refNome='';
                this.airbagmodelo=0; //this.evtarget.value='';
            },
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
openSearch(){
    if (this.opsearch==true){
        this.opsearch=false;
        this.loadList();
    } else{
        this.opsearch=true
        
    }
},
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
printVall(){
/* 
    let vol={};
    vol=this.refMarcaVals;
    Object.entries(vol).forEach(jobj => {
        console.log(jobj.id+" "+jobj.Nome);
        console.log(jobj);
        });
       // console.log(this.$refs.refUpdMarca.value);
 */
   // let vil=this.refMarcasCP;
  //  vil.forEach((ell)=>{ console.log(ell); })   
 // console.log(this.refMarcaVals);
},
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){
    //<option :value="storex.item"></option>
    this.fileInputKey=this.storex.item.ID;
    
 },
   /* . . . . . . . . . . . . . . . . . . . */
   /* . . . . . . . . . . . . . . . . . . . */
     setRefMarcas(){

    //if ( this.amountReq==2 ){
    let uriI=this.urlBase+"?refmarcavalues=true"; //refMarcavalues
    //console.log("11111111 "+uriI);
    let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      axios.get(uriI, config)
          .then(response => {
             this.refMarcaVals = response.data;
             this.amountReq++;
          })
          .catch(errors => {
              console.log(errors)
          });

  
   // }    
   },  
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
  resetValues(){
  // this.$refs.updNome.value='';
   this.evtarget.value='';
    //this.fileInputKey=-1;
    console.log(this.fileImagem[0]);
    //if (this.$refs.updNome!=undefined){
      console.log(this.storex.item.Nome);
   //}
   //this.$refs.updNome.value='';
  },
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
searchh(){
    this.storex.transact.status='';
    this.storex.transact.message='';
    let vallSearch='';
    let urii="";
//inputid inputNome inputPortas inputAssentos inputairbags inputabs
//let valss=window.btoa(this.selected+'&&&'+this.inpSearchId)
    if (this.$refs.inputid.value!=''){
        vallSearch="id="+this.$refs.inputid.value;
    }
    if (this.$refs.inputNome.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="nome="+this.$refs.inputNome.value;
    }
      if (this.$refs.inputPortas.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="portas="+this.$refs.inputPortas.value;
    }
      if (this.$refs.inputAssentos.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch="assentos="+this.$refs.inputAssentos.value;
    }
      if (this.$refs.inputairbags.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="air_bag="+this.$refs.inputairbags.value;
    }
      if (this.$refs.inputabs.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="abs="+this.$refs.inputabs.value;
    }
    // - - - - - - - - - - - - - - - - - -
    vallSearch=window.btoa(vallSearch);
    vallSearch="?filter="+vallSearch;
    urii=this.urlBase+vallSearch;
   let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      console.log(vallSearch);
      axios.get(urii, config)
          .then(response => {
              this.modelosdata = response.data;
             // this.datasearch = response.data;
              //this.insearch='true';
              //console.log(this.datasearch);
          })
          .catch(errors => {
            alert("Não foi possível localizar");
              console.log(" - - - -");
              console.log(errors.response.data.message);
          })


},
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
  updateh() {
    this.storex.transact.status='';
    this.storex.transact.message='';
   // this.nomemodelo=this.storex.item.Nome; 
    this.refNome=this.$refs.refUpdMarca.value;
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('nome', this.storex.item.Nome);
    formData.append('marca_id',this.refNome);
    formData.append('portas',this.storex.item.Portas);
    formData.append('assentos',this.storex.item.Assentos);
    formData.append('air_bag',this.storex.item['Air Bag']);
    formData.append('abs',this.storex.item.ABS);
    //formData.append('',this.storex.item.);
 
    if(this.fileImagem[0]) {
        formData.append('imagem', this.fileImagem[0]);
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
        this.storex.transact.status = 'success';
        this.storex.transact.message = 'O registro foi atualizado!';
          console.log("Enter response");
       //
        this.loadList();
          // this.storex.item.Nome=this.nomemodelo;
            //this.fileInputKey=0;
    })
    .catch(errors => {
        
         this.storex.transact.status = 'error';
         this.storex.transact.message = errors.response.data.message;
       
        console.log("Enter errors");
      
        
    })
},
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
  deleteh() {
    this.storex.transact.status='';
    this.storex.transact.message='';
     let formData = new FormData();
     formData.append('_method', 'DELETE')

        let config = {
        headers: {
            'Accept': 'application/json',
            'Authorization': this.token
        }
    }
     let url = this.urlBase + '/' + this.storex.item.ID

     axios.post(url, formData,config)
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
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
  loadList() {
    
      let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      //console.log("List Loaded");
      axios.get(this.urlBase, config)
          .then(response => {
              this.modelosdata = response.data
              console.log(this.modelosdata)
          })
          .catch(errors => {
              console.log(errors)
          })
 },
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */ 
/* . . . . . . . . . . . . . . . . . . . */
            loadImagem(e) {
                // e.target.value='';
                this.evtarget=e.target;
                this.fileImagem = e.target.files;
               
               //console.log(e.target.files);
            },
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
    saveh() {
        console.log(this.nomemodelo, this.fileImagem[0])
/* nomemodelo  portasmodelo assentosmodelo 
airbagmodelo absmodelo refNome this.fileImagem[0] */
        let formData = new FormData();
        formData.append('nome', this.nomemodelo);
        formData.append('portas', this.portasmodelo);
        formData.append('assentos', this.assentosmodelo);
        formData.append('air_bag', this.airbagmodelo);
        formData.append('abs', this.absmodelo);
        formData.append('marca_id', this.refNome);
        formData.append('imagem', this.fileImagem[0]);

        let config = {
            headers: {                    
           'Content-Type': 'multipart/form-data',
           'Accept': 'application/json',
           'Authorization': this.token
           }
        }

        axios.post(this.urlBase, formData, config)
         .then(response => {
             this.storex.transact.status = 'success';
             this.storex.transact.message = 'Register ID: '+response.data.id; 
             //console.log("\n[add]The response Value: "+JSON.stringify(response))
              this.loadList()
        })
       .catch(errors => {
         this.storex.transact.status = 'error';
             this.storex.transact.message = errors.response.data.message; 

        })

    }
/* . . . . . . . . . . . . . . . . . . . */
   
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
},
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
        mounted() {  
            this.loadList();
            this.setRefMarcas();
            

        }
    }
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */

</script>




<template>
    <div class="container">
    <div class="row justify-content-center">
    <div class="container-fluid col-md-8">

 <!-- = = = = = = = =  =  [BEGIN] -->
<!-- = = = = = = = =  =  [ of ] -->
<!-- = = = = = = = =  =  [ SEARCH ] -->
 <!-- = = = = = = = =  =  =  = = [COMPONENT][Card:Search] -->


<card-cp title="Search for models">
    <template v-slot:content>
  
<p v-if="opsearch==false">
  <a class="btn btn-primary" @click="openSearch()">
    Abrir Pesquisa
  </a>
</p>
<p v-if="opsearch==true">
<button class="btn btn-danger"  @click="openSearch()">
      Abrir Pesquisa  
     </button>
</p>
<div id="collSearch" v-if="opsearch==true">

       <input type="number"  class="form-control mb-2" id="inputid" aria-describedby="idHelp" placeholder="ID" ref="inputid">
     <input type="text" class="form-control mb-2" id="inputNome" aria-describedby="NomeHelp"
        placeholder="Nome of model"  ref="inputNome">
     <input type="number" class="form-control mb-2" id="inputPortas" aria-describedby="NomeHelp"
        placeholder="amount of Portas"  ref="inputPortas">

        <input type="number" class="form-control mb-2" id="inputAssentos" aria-describedby="NomeHelp"
        placeholder="amount of Assentos"  ref="inputAssentos">
        <input type="number" class="form-control mb-2" id="inputairbags" aria-describedby="NomeHelp"
        placeholder="1 if have air bag - 0 if don't have air bag"  ref="inputairbags">
        <input type="number" class="form-control mb-2" id="inputabs" aria-describedby="NomeHelp"
        placeholder="1 if have abs - 0 if don't have abs"  ref="inputabs">

     <p><button class="btn btn-primary btn-sm mb-3" @click="searchh()">Localizar</button></p>

</div>
    
 
   
    </template>
    </card-cp>
     
    
 <!-- = = = = = = = =  =  [End of Card:Search] = -->

 <!-- = = = = = = = =  =  [ADD] -->
<!-- = = = = = = = =  =  [ ADD ] -->
<!-- = = = = = = = =  =  [ ADD ] -->
<!-- = = = = = = = =  =  =[COMPONENT][Modal:Add]-->
<dmodal-cp modalname="modalAdd" title="Add Model">
<template v-slot:alerts> 

 <alert-cp stll="success" title="O Item foi adicionado com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="Erro ao adicionar um item - consulte o system administrator" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>

     
</template>

    <template v-slot:content> 
    <div class="container-sm">
    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="newNomeHelp">Nome</span>
    <input type="text" class="form-control" id="newNome" placeholder="Nome of model" 
    aria-describedby="newNomeHelp" v-model="nomemodelo"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaPortas">Portas</span>
    <input type="number" class="form-control" id="portasmodelo" placeholder="quantidade de portas" 
    aria-describedby="ariaPortas" v-model="portasmodelo"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaAssentos">Assentos</span>
    <input type="number" class="form-control" id="assentosmodelo" placeholder="quantidade de assentos" 
    aria-describedby="ariaAssentos" v-model="assentosmodelo"></div>
   
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariabags">Air Bags</span>
    <input type="number" class="form-control" id="airbagmodelo" placeholder="Possui Air bag? 0-Não 1-Sim" 
    aria-describedby="ariabags" v-model="airbagmodelo"></div>

    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaabs">ABS</span>
    <input type="number" class="form-control" id="absmodelo" placeholder="Possui ABS?" 
    aria-describedby="ariaabs" v-model="absmodelo"></div>

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Marca</span>
    <select v-model="refNome" class="form-select form-select-sm">
        <option v-for="itt in refMarcasCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    <div class="form-group"> <!-- = =[Input:Imagem] = = -->
     
    <input-cp title="Imagem" id="newImagem" id-help="newImagemHelp"
    text-help="Seleciona a imagem no formato png">
    <input type="file" class="form-control-file" id="newImagem" aria-describedby="newImagemHelp" placeholder="Selecione a imagem"
    @change="loadImagem($event)">
    </input-cp> 
    </div>
    

    </div>
    </template>

      <template v-slot:footer>
       &nbsp;<button type="button" class="btn btn-secondary" @click="resetForm()" >Limpar dados</button>
        &nbsp;<button type="button" class="btn btn-primary" @click="saveh()">save</button>
        </template>
</dmodal-cp>

    <!-- = = = = = = = =  =  [End of Modal] -->


        <!-- = = = = = = = =  =  [VIEW] -->
        <!-- = = = = = = = =  =  [ VIEW ] -->
        <!-- = = = = = = = =  =  [ VIEW ] -->


<dmodal-cp modalname="modalView" title="Visualizando o modelo">
       <template v-slot:alerts></template>
       <template v-slot:content> 
    
   <h4>{{storex.item.Nome}}</h4> <hr>

    

    <div class="container">
  <div class="row">
    <div class="col">Marca: {{storex.item.Marca}}</div>
    <div class="col">ID: {{storex.item.ID}}</div>
    <div class="col">
    </div>
  </div>

  <div class="row">
    <div class="col">
    <img :src="'/'+storex.item.Imagem" width="193" height="122">
    </div>
    <div class="col"></div>
    <div class="col"></div>
  </div>

  <div class="row">
    <div class="col">Portas: {{storex.item.Portas}}</div>
    <div class="col">Air Bag: {{storex.item['Air Bag']}}</div>
    <div class="col">Assentos: {{storex.item.Assentos}}</div>
  </div>

   <div class="row">
    <div class="col">ABS: {{storex.item.ABS}}</div>
    <div class="col"></div>
    <div class="col"></div>
  </div>

</div>
       
       <br>
       </template>
       <template v-slot:footer>
       </template>

   </dmodal-cp>

    <!-- = = = = = = = =  =  [UPDATE] -->
    <!-- = = = = = = = =  =  [ UPDATE ] -->
    <!-- = = = = = = = =  =  [ UPDATE ] -->

 <dmodal-cp modalname="modalUpd" title="Update Model">
  <template v-slot:alerts>
    <alert-cp stll="success" title="Atualização realizada com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="erro na atualização - consultar o system administrator" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>
  </template>

    <template v-slot:content> 
       {{setUpdValues()}} 
    <div class="container-sm">
    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="newNomeHelp">Nome</span>
    <input type="text" class="form-control" id="newNome" placeholder="Nome of model" 
    aria-describedby="newNomeHelp" v-model="storex.item.Nome"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaPortas">Portas</span>
    <input type="number" class="form-control" id="portasmodelo" placeholder="amount" 
    aria-describedby="ariaPortas" v-model="storex.item.Portas"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaAssentos">Assentos</span>
    <input type="number" class="form-control" id="assentosmodelo" placeholder="amount" 
    aria-describedby="ariaAssentos" v-model="storex.item.Assentos"></div>
   
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariabags">Air Bags</span>
    <input type="number" class="form-control" id="airbagmodelo" placeholder="amount" 
    aria-describedby="ariabags" v-model="storex.item['Air Bag']"></div>

    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaabs">ABS</span>
    <input type="number" class="form-control" id="absmodelo" placeholder="amount" 
    aria-describedby="ariaabs" v-model="storex.item.ABS"></div>

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Marca</span>
    <select ref="refUpdMarca" class="form-select form-select-sm">
        <option :value="storex.item.Marca_ID" selected>{{storex.item.Marca}}</option>
        <option v-for="itt in refMarcasCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    <div class="form-group"> <!-- = =[Input:Imagem] = = -->
     
    <input-cp title="Imagem" id="newImagem" id-help="newImagemHelp"
    text-help="Select the Imagem in format PNG">
    <input type="file" class="form-control-file" id="newImagem" aria-describedby="newImagemHelp" placeholder="Select a Imagem"
    @change="loadImagem($event)">
    </input-cp> 
    </div>
        </div>
       </template>

       <template v-slot:footer>
       <button type="button" class="btn btn-secondary" @click="resetValues()">Clear</button>
        <button type="button" class="btn btn-primary" @click="updateh()">Update</button>
       </template>

   </dmodal-cp>
 <!-- = = = = = = = =  =  [DELETE] -->
<!-- = = = = = = = =  =  [ DELETE ] -->
<!-- = = = = = = = =  =  [ DELETE ] -->
<dmodal-cp modalname="modalDel" title="View Marca">
       <template v-slot:alerts>
           <alert-cp stll="success" title="Deleted  with success" :details="storex.transact" v-if="storex.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="error to delete proccess" :details="storex.transact" v-if="storex.transact.status == 'error'"></alert-cp>
       </template>
       <template v-slot:content> 
       <h4>Excluir o Modelo de veículo com o seguinte conteúdo:</h4><hr>
       <li> ID: {{storex.item.ID}}</li>
       <li> Nome: {{storex.item.Nome}}</li>
       <li> Imagem: <img :src="'/'+storex.item.Imagem" width="150" height="87"></li>
       <br>
       </template>
       <template v-slot:footer>
         <button type="button" class="btn btn-danger" @click="deleteh()" v-if="storex.transact.status != 'success'">Confirm</button>
       </template>

   </dmodal-cp>









        <!-- = = = = = = = =  =  [LIST] -->
        <!-- = = = = = = = =  =  [ LIST ] -->
        <!-- = = = = = = = =  =  [ LIST ] -->

<!-- = = = = = = = =  =  =[COMPONENT][Card:List]  -->
<card-cp title="Lista de modelos de veículos">

    <template v-slot:content>
     <table-cp :dbdatas="modelosdata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView'}"
               :ddel="{visible:true, dataTarget:'modalDel'}"
               :dupd="{visible:true, dataTarget:'modalUpd'}"
               :config="{title:'Operations', amountcolls: 1, refrow:'ref_marca',refname:'nome', visible:true, typer:'last', imagefield:'Imagem',funvisible:false}"
              
     ></table-cp>
      </template>

      <template v-slot:footer>
      <button type="button" class="btn btn-primary btn-sm float-right"
      onclick="document.getElementById('modalAdd').style.display='block'">Adicionar</button>
<!--button type="button" class="btn btn-primary btn-sm float-right"
      @click="printVall()">VVV</button -->
     

    </template>

    </card-cp>
<!-- = = = = = = = =  =  = [End of Card:List] = -->


</div>
</div>
</div>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
</template>
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->




<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
