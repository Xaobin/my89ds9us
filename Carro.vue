
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = 
__   ___   _  ___ 
\ \ / | | | |/ _ \
 \ V /| |_| |  __/
  \_/  \__,_|\___|            
 =  =  =  =  =  =  -->
<script>
/*
id 	modelo_id 	placa 	disponivel 	km 	created_at 	updated_at
*/
import { useStore } from '../store/store1'
    export default {
        setup() {
	            const storex = useStore();      
		        return { storex };
	        },
/* . . . . . . . . . . . . . . . . . . . */             
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
    placa:{title:'Placa', ordershow:2,visible:true},
    disponivel:{title:'Disponivel', ordershow:3, visible:true},
    km:{title:'KM', ordershow:4, visible:false},
    updated_at:{title:'Atualizado', ordershow:5, visible:false},
    created_at:{title:'Criado', ordershow:6, visible:false},
    modelo:{title:'Modelo', ordershow:7,visible:true},
    modelo_id:{title:'Model_ID', ordershow:8, visible:false}
    
            }; 
             return atitles;
     },
/* . . . . . . . . . . . . . . . . . . . */      
    refmodelsCP(){
        let neovar=[];
        Object.entries(this.refModeloVals).forEach(jobj => {
            let tmpv=[];
            const pn = Object.keys(jobj);
            tmpv[0]=jobj['1'].id;
            tmpv[1]=jobj['1'].model; // !!!!!!!
            neovar.push(tmpv);
        });
      
        return neovar;
    }
 /* . . . . . . . . . . . . . . . . . . . */           
        },
 /* . . . . . . . . . . . . . . . . . . . */         
        data() {
            return {
                urlBase: '/api/carro',
                cplaca:'',
                cdisponivel:0,
                ckm:0,
                refname:'',

                //amountReq: 0,
                refModeloVals: {},
                carrosdata:[],
               
               // fileInputKey: 0,
                evtarget:'',
                selected:'id',
                opsearch:false,
                
               // datasearch:[],
              //  insearch:'false'
                
            }
        },
 /* . . . . . . . . . . . . . . . . . . . */
        methods: {
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
printVall(){
///* 
    let vol={};
    vol=this.refModeloVals;
    Object.entries(vol).forEach(jobj => {
        //console.log(jobj.id+" "+jobj.name);
        console.log(jobj);
        });
       // console.log(this.$refs.refUpdModel.value);
 //*/
   // let vil=this.refmodelsCP;
    //vil.forEach((ell)=>{ console.log(ell); })       
},
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){
    //<option :value="storex.item"></option>
    //this.fileInputKey=this.storex.item.ID;
    
 },
   /* . . . . . . . . . . . . . . . . . . . */
     setRefModels(){
    ///busca no db os modelos
    ///nível de cadastro/update   
    let uriI=this.urlBase+"?refmodelovalues=true"; 
    
    let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      axios.get(uriI, config)
          .then(response => {
             this.refModeloVals = response.data;
            // this.amountReq++;
          })
          .catch(errors => {
              console.log(errors)
          });

  this.printVall();
   // }    
   },  

 /* . . . . . . . . . . . . . . . . . . . */
  resetValues(){
  // .$refs.updName.value='';
    this.evtarget.value='';
    //this.fileInputKey=-1;
   // console.log( .fileImage [0]);
    // (.$refs.updName!=undefined){
    //  console.log(.storex.item.name);
   //}
   //.$refs.updName.value='';
    this.cplaca:''; this.cdisponivel:0;
    this.ckm:0;  //this.refname:'';
  },

 /* . . . . . . . . . . . . . . . . . . . */
  /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
searchh(){
    this.storex.transact.status='';
    this.storex.transact.message='';
    let vallSearch='';
    let urii="";
//inputid inputname inputdoors inputseats inputairbags inputabs
//let valss=window.btoa(this.selected+'&&&'+this.inpSearchId)
    if (this.$refs.inputid.value!=''){
        vallSearch="id="+this.$refs.inputid.value;
    }
    if (this.$refs.inputplate.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="plate="+this.$refs.inputplate.value;
    }

    if (this.$refs.inputavail.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="available="+this.$refs.inputavail.value;
    }
      if (this.$refs.inputkm.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="km="+this.$refs.inputkm.value;
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
              this.carrosdata = response.data;
             // this.datasearch = response.data;
              //this.insearch='true';
              //console.log(this.datasearch);
          })
          .catch(errors => {
            alert("A pesquisa foi realizada e nada foi encontrado!");
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
   // this.namemodel=this.storex.item.Name; 
   // this.refname=this.$refs.refUpdModel.value;
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('placa', this.storex.item.Plate);
    formData.append('modelo_id',this.$refs.refUpdModel.value);
    formData.append('disponivel',this.storex.item.Disponivel);
    formData.append('km',this.storex.item.KM);
   
    
 /*
    // this. fileImage [0] ) {
    / //   formData .append('image', this . fileImage[0] );
    ///    this.resetValues();
  ///  }
*/
    let url = this.urlBase + '/' + this.storex.item.ID

    let config = {
        headers: {
           /// 'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
            'Authorization': this.token
        }
    }

    axios.post(url, formData, config)
    .then(response => {
        this.storex.transact.status = 'success';
        this.storex.transact.message = 'Atualização feita!';
          console.log("Enter response");
       //
        this.loadList();
          // this.storex.item.name=this.namemodel;
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
              this.carrosdata = response.data
              //console.log(this.brands)
          })
          .catch(errors => {
              console.log(errors)
          })
 },
/* . . . . . . . . . . . . . . . . . . . */
            //loadImage(e) {
                // e.target.value='';
                //this.evtarget=e.target;
                //this.fileImage = e.target.files;
               
               //console.log(e.target.files);
            //},
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */
    saveh() {
        
        let formData = new FormData();
        formData.append('placa', this.cplaca);
        formData.append('disponivel', this.cdisponivel);
        formData.append('km', this.ckm);
       
        formData.append('modelo_id', this.$refs.refModeloFm.value);
        

        let config = {
            headers: {                    
           //'Content-Type': 'multipart/form-data',
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
        },
/* . . . . . . . . . . . . . . . . . . . */
        mounted() {  
            this.loadList();
           this.setRefModels();
            

        }
    }
/* . . . . . . . . . . . . . . . . . . . */
/* . . . . . . . . . . . . . . . . . . . */


</script>

<template>
    <div class="container">
    <div class="row justify-content-center">
    <div class="container-fluid col-md-8">

 <!--                    _     
                        | |    
 ___  ___  __ _ _ __ ___| |__  
/ __|/ _ \/ _` | '__/ __| '_ \ 
\__ |  __| (_| | | | (__| | | |
|___/\___|\__,_|_|  \___|_| |_|
                               
 -->
 <!-- = = = = = = = =  =  =  = = [COMPONENT][Card:Search] -->


<card-cp title="Busca por Carros">
    <template v-slot:content>
  
<p v-if="opsearch==false">
  <a class="btn btn-primary" @click="openSearch()">Abrir pesquisa</a>
</p>
<p v-if="opsearch==true">
<button class="btn btn-danger"  @click="openSearch()">Fechar pesquisa</button>
</p>
<div id="collSearch" v-if="opsearch==true">

       <input type="number"  class="form-control mb-2" id="inputid" aria-describedby="idHelp" placeholder="ID" ref="inputid">

  <input type="text" class="form-control mb-2" id="inputplate" aria-describedby="Placa"
        placeholder="Placa"  ref="inputplate">

     <input type="text" class="form-control mb-2" id="inputavail" aria-describedby="Disponívl"
        placeholder="Disponibilidade"  ref="inputavail">

     <input type="number" class="form-control mb-2" id="inputkm" aria-describedby="Quilometros"
        placeholder="Kilometros"  ref="inputkm">

   

     <p><button class="btn btn-primary btn-sm mb-3" @click="searchh()">Localizar</button></p>

</div>
    
 
   
    </template>
    </card-cp>
     



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
<dmodal-cp modalname="modalAdd" title="Adicionar Carro">
<template v-slot:alerts> 

 <alert-cp stll="success" title="Adição realizada com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="Erro no cadastro - contate o system administrator" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>

     
</template>

    <template v-slot:content> 
    <div class="container-sm">
    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="newplateHelp">Placa</span>
    <input type="text" class="form-control" id="newPlate" placeholder="Digite a placa" 
    aria-describedby="newPlateHelp" v-model="cplaca"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariadoors">Disponível</span>
    <input type="number" class="form-control" id="disponivelID" 
    placeholder="Está disponível" 
    aria-describedby="disponivelID" v-model="cdisponivel"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaseats">Km</span>
    <input type="number" class="form-control" id="km_car" placeholder="Kilometros" 
    aria-describedby="km_car" v-model="ckm"></div>
   

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Modelo</span>
    <select ref="refModeloFm" class="form-select form-select-sm">
        <option v-for="itt in refmodelsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    
    </div>
    </template>

      <template v-slot:footer>
        &nbsp;<button type="button" class="btn btn-primary" @click="saveh()">Salvar</button>
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
<dmodal-cp modalname="modalView" title="Visualizar Carro">
       <template v-slot:alerts></template>
       <template v-slot:content> 
    
   <h4>{{storex.item.Placa}}</h4> <hr>

    
<div class="container">
  
    <li class="col">Placa: {{storex.item.Placa}}</li>
    <li class="col">ID: {{storex.item.ID}}</li>
    <li class="col">Disponível: {{storex.item.Disponivel}}</li>
    <li class="col">Quilometros: {{storex.item.KM}}</li>
    <li class="col">Criado em: {{storex.item.Criado}}</li>
    <li class="col">Atualizado em: {{storex.item.Atualizado}}</li>
  

</div>
       
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
 <dmodal-cp modalname="modalUpd" title="Atualizar carro">
  <template v-slot:alerts>
    <alert-cp stll="success" title="Atualização realizada!" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="erro na atualização" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>
  </template>

    <template v-slot:content> 
       {{setUpdValues()}} 
    <div class="container-sm">
    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="newNameHelp">Placa</span>
    <input type="text" class="form-control" id="newName" placeholder="Placa" 
    aria-describedby="Placa" v-model="storex.item.Placa"></div>

    
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariadoors">Disponível</span>
    <input type="number" class="form-control" id="disponivelID" placeholder="Está disponível? (1-Sim) (0-Não)" 
    aria-describedby="Disponibilidade" v-model="storex.item.Disponivel"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="ariaseats">Quilômetros</span>
    <input type="number" class="form-control" id="km_car" placeholder="Kilometros" 
    aria-describedby="Kilometros" v-model="storex.item.KM"></div>

    <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="ariaabs">Modelo</span>
    <select ref="refUpdModel" class="form-select form-select-sm">
        <option :value="storex.item.Modelo_ID" selected>{{storex.item.Modelo}}</option>
        <option v-for="itt in refmodelsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

    
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
<dmodal-cp modalname="modalDel" title="Visualizar carro">
       <template v-slot:alerts>
           <alert-cp stll="success" title="Excluído com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="Erro na exclusão do veículo" :details="storex.transact" v-if="storex.transact.status == 'error'"></alert-cp>
       </template>
       <template v-slot:content> 
       <h4>Excluir o veículo com o seguinte conteúdo</h4><hr>
       <li> ID: {{storex.item.ID}}</li>
       <li> Placa: {{storex.item.Placa}}</li>
       <li> KM: {{storex.item.KM}}</li>
       <br>
       </template>
       <template v-slot:footer>
         &nbsp;<button type="button" class="btn btn-danger" @click="deleteh()" v-if="storex.transact.status != 'success'">Confirmar</button>
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
<card-cp title="Lista de veículos cadastrados">

    <template v-slot:content>
     <table-cp :dbdatas="carrosdata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView'}"
               :ddel="{visible:true, dataTarget:'modalDel'}"
               :dupd="{visible:true, dataTarget:'modalUpd'}"
               
               :config="{title:'Operations', amountcolls: 1, refrow:'car_model',refname:'name', visible:true, typer:'last', imagefield:'Nullable',funvisible:false}"
              
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
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->



