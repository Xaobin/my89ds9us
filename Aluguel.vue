<!-- = = = = = = = 
__   ___   _  ___ 
\ \ / | | | |/ _ \
 \ V /| |_| |  __/
  \_/  \__,_|\___|            
 =  =  =  =  =  =  -->
<script>
import { useStore } from '../store/store1'
    export default {
        setup() {
	            const storex = useStore();   
                 let value=[{"id":0,"cliente_id":0,"carro_id":0,"data_inicial":"","data_final_esperada":"","data_final_realizada":"","taxa_diaria":0,"km_inicial":0,"km_final":null,"created_at":"","updated_at":"",
    "veiculo":[{"Modelo":"","Marca":"","Imagem_marca":"","Imagem_modelo":""}],
    "tem_carro":{"id":0,"modelo_id":0,"placa":"","disponivel":0,"km":0,"created_at":"","updated_at":""},
    "tem_cliente":{"id":0,"nome":"","created_at":"","updated_at":""}}];
                storex.item=value;   
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
    tem_carro:{title:'Placa', ordershow:2, visible:true},
    tem_cliente:{title:'Cliente', ordershow:3, visible:true},
    cliente_id:{title:'cliente_id', ordershow:4, visible:false},
    carro_id:{title:'carro_id', ordershow:5, visible:false},
    taxa_diaria:{title:'Taxa_diaria', ordershow:6, visible:false},
    km_inicial:{title:'KM_inicial', ordershow:7,visible:true},
    km_final:{title:'KM_final', ordershow:8, visible:false},
     data_inicial:{title:'Data_inicial', ordershow:9, visible:false},
    data_final_esperada:{title:'Data_esperada', ordershow:10,visible:false},
    data_final_realizada:{title:'Data_final', ordershow:11, visible:false}
    
            }; 
             return atitles;
     },
/* . . . . . . . . . . . . . . . . . . . */      
    refclientsCP(){
        let neovar=[];
        Object.entries(this.refClienteVals).forEach(jobj => {
            let tmpv=[];
            const pn = Object.keys(jobj);
            tmpv[0]=jobj['1'].id;
            tmpv[1]=jobj['1'].nome; // !!!!!!!
            neovar.push(tmpv);
        });
      
        return neovar;
    },
/* . . . . . . . . . . . . . . . . . . . */      
    refCarrosCP(){
        let neovar=[];
        Object.entries(this.refCarroVals).forEach(jobj => {
            let tmpv=[];
            const pn = Object.keys(jobj);
            tmpv[0]=jobj['1'].id;
            tmpv[1]=jobj['1'].placa; // !!!!!!!
            tmpv[2]=jobj['1'].disponivel;
            tmpv[3]=jobj['1'].modelo;
            neovar.push(tmpv);
        });
      
        return neovar;
    },
 /* . . . . . . . . . . . . . . . . . . . */           
    currentDateCP(){
        //0000-00-00 00:00:00
        const datey = new Date();
        let yy= datey.getFullYear();
        let mm= datey.getMonth() + 1;
        let dd= datey.getDay();
        let allyear=dd+"/"+mm+"/"+yy;
        let hours=datey.getHours();
        let minutes=datey.getMinutes();
        let seconds=datey.getSeconds();
        return allyear+", "+hours+':'+minutes+':'+seconds;

    }
 /* . . . . . . . . . . . . . . . . . . . */    
        },
 /* . . . . . . . . . . . . . . . . . . . */         
        data() {
            return {
                urlBase: '/api/aluguel',
                aplaca:'',
                adisponivel:0,
                kmcarro:0,
                refname:'',

                ratex: 0,
                refClienteVals: {},
                refCarroVals: {},
                basedata:[],
               
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
calcVall(){
 //console.log(this.$refs.dataFinalX.value);
 //console.log("-------------------");
    let taxaDiariaX = this.$refs.taxaDiariaX.value;
    let dataInicioX = this.$refs.dataInicioX.value;
    let dataFimX = this.$refs.dataFimX.value;
    let date_1 = new Date(dataInicioX);
    let date_2 = new Date(dataFimX);
    let difference = date_1.getTime() - date_2.getTime();
    let TotalDias = Math.abs(Math.ceil(difference / (1000 * 3600 * 24)));
        this.ratex=taxaDiariaX*TotalDias;
        if (isNaN(this.ratex)){ this.ratex="Fill all" ;}
},
 /* . . . . . . . . . . . . . . . . . . . */
calcVallT2(){
 //console.log(this.storex.item[0].FINAL_DATE);
 //console.log("-------------------");
    let taxaDiariaX = this.storex.item[0].taxa_diaria;
    let dataInicioX = this.storex.item[0].data_inicial;
    let dataFimX = this.storex.item[0].data_final_realizada;
    let date_1 = new Date(dataInicioX);
    let date_2 = new Date(dataFimX);
    let difference = date_1.getTime() - date_2.getTime();
    let TotalDias = Math.abs(Math.ceil(difference / (1000 * 3600 * 24)));
        this.ratex=taxaDiariaX*TotalDias;
        if (isNaN(this.ratex)){ this.ratex="Fill all" ;}
},
 /* . . . . . . . . . . . . . . . . . . . */
 setUpdValues(){
    //<option :value="storex.item"></option>
    //this.fileInputKey=this.storex.item[0].ID;
   // this.ratex=0;
   //if (this.ratex!=0){ this.ratex=0; }
    
 },
   /* . . . . . . . . . . . . . . . . . . . */
     setRefClients(){
///Busca na base de dados os modelos - nível cadastro/update
    let uriI=this.urlBase+"?getclientesvalues=true"; 
    //console.log("11111111 "+uriI);
    let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      axios.get(uriI, config)
          .then(response => {
             this.refClienteVals = response.data;
            // this.amountReq++;
          })
          .catch(errors => {
              console.log(errors)
          });
  
   },  
    
 /* . . . . . . . . . . . . . . . . . . . */
 setRefCars(){
///Busca na base de dados os modelos - nível cadastro/update
    let uriI=this.urlBase+"?getcarrosvalues=true"; 
    //console.log("11111111 "+uriI);
    let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      axios.get(uriI, config)
          .then(response => {
             this.refCarroVals = response.data;
            // this.amountReq++;
          })
          .catch(errors => {
              console.log(errors)
          });
  
   }, 
 initValuesITEM(){
    let value=[{"id":0,"cliente_id":0,"carro_id":0,"data_inicial":"","data_final_esperada":"","data_final_realizada":"","taxa_diaria":0,"km_inicial":0,"km_final":null,"created_at":"","updated_at":"",
    "veiculo":[{"Modelo":"","Marca":"","Imagem_marca":"","Imagem_modelo":""}],
    "tem_carro":{"id":0,"modelo_id":0,"placa":"","disponivel":0,"km":0,"created_at":"","updated_at":""},
    "tem_cliente":{"id":0,"nome":"","created_at":"","updated_at":""}}];
    this.storex.setItem(value);
   }, 
 /* . . . . . . . . . . . . . . . . . . . */
  resetValues(){
  
  },
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
searchh(){
    this.storex.transact.status='';
    this.storex.transact.msg='';
    let vallSearch='';
    let vss= this.$refs.inputDataInicial.value;
    //console.log((typeof vss)+"..."+vss); //string...2023-03-22T00:00
    //console.log(vss.search('0000')); //-1

    let urii="";
//inputID inputPlaca inputModelo inputCliente inputDataInicial
//inpSelectKMStart  inputKMStart
    if (this.$refs.inputID.value!=''){
        vallSearch="id="+this.$refs.inputID.value;
    }
    if (this.$refs.inputPlaca.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="placa="+this.$refs.inputPlaca.value;
    }

    if (this.$refs.inputModelo.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="modelo="+this.$refs.inputModelo.value;
    }
      if (this.$refs.inputCliente.value!=''){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="cliente="+this.$refs.inputCliente.value;
    }
      if ((vss.search('0000')==-1)&&(vss!='')){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="data_inicial="+this.$refs.inputDataInicial.value;
    }
      if (this.$refs.inputKMStart.value>0){
        if (vallSearch!=''){vallSearch+="@@"; }
        vallSearch+="km_inicial"+this.$refs.inpSelectKMStart.value+this.$refs.inputKMStart.value;
    }
    // - - - - - - - - - - - - - - - - - -
   // console.log(this.$refs.inputCliente.value);
    vallSearch=window.btoa(vallSearch);
    vallSearch=vallSearch.replace("+","kkpkk");
    vallSearch="?filter="+vallSearch;
    urii=this.urlBase+vallSearch;
   let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
    
      axios.get(urii, config)
          .then(response => {
              this.basedata = response.data;
            
          })
          .catch(errors => {
            alert("the resource was not found");
              console.log(" - - - -");
              console.log(errors.response.data.msg);
          })


},
/* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
 /* . . . . . . . . . . . . . . . . . . . */
  updateh() {
    this.storex.transact.status='';
    this.storex.transact.msg='';
   // this.namemodel=this.storex.item[0].Name; 
   // this.refname=this.$refs.refUpdModel.value;
    let formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('taxa_diaria', this.$refs.updTXDiaria.value);
    formData.append('km_inicial',this.$refs.updKMInicial.value);
    formData.append('km_final',this.$refs.updKMFinal.value);
    formData.append('data_inicial',this.$refs.updDInicial.value);
    formData.append('data_final_esperada', this.$refs.updDFEsperada.value);
    formData.append('data_final_realizada',this.$refs.updDFRealizada.value);
   

    let url = this.urlBase + '/' + this.storex.item[0].id;

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
        this.storex.transact.msg = 'O registro foi atualizado!';
        this.setRefCars();
          console.log("Enter response");
       //
        this.loadList();
          // this.storex.item[0].name=this.namemodel;
            //this.fileInputKey=0;
    })
    .catch(errors => {
        
         this.storex.transact.status = 'error';
         this.storex.transact.msg = errors.response.data.msg;
       
        console.log("Enter errors");
      
        
    })
},
 /* . . . . . . . . . . . . . . . . . . . */
  deleteh() {
    this.storex.transact.status='';
    this.storex.transact.msg='';
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
             this.storex.transact.msg = response.data.msg;
             this.loadList(); 
              this.setRefCars();
         })
         .catch(errors => {
             this.storex.transact.status = 'error';
             this.storex.transact.msg = errors.response.data.msg;
         })
        

  },
 /* . . . . . . . . . . . . . . . . . . . */
  loadList() {
      //this.initValuesITEM();
      let config = {
          headers: {
              'Accept': 'application/json',
              'Authorization': this.token
          }
      }
      //console.log("List Loaded");
      axios.get(this.urlBase, config)
          .then(response => {
              this.basedata = response.data
              console.log(response.data);
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
    saveh() {
     /// 'cliente_id', 'carro_id', 'data_inicial 'data_final_esperada',
     //'data_final_realizada','daily_rate','km_start','km_final'
    
    
        let formData = new FormData();
        formData.append('cliente_id', this.$refs.clienteX.value);
        formData.append('carro_id', this.$refs.carroX.value);
        formData.append('taxa_diaria', this.$refs.taxaDiariaX.value);
        formData.append('km_inicial', this.$refs.kmInicialX.value);
        formData.append('km_final', this.$refs.kmFinalX.value);
        formData.append('data_inicial', this.$refs.dataInicioX.value);
        formData.append('data_final_esperada', this.$refs.dataFimX.value);
        formData.append('data_final_realizada', this.$refs.dataFinalX.value);
 
        console.log(formData);

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
             this.storex.transact.msg = 'Register ID: '+response.data.id; 
             //console.log("\n[add]The response Value: "+JSON.stringify(response))
              this.loadList();
               this.setRefCars();
               this.initValuesITEM();
        })
       .catch(errors => {
         this.storex.transact.status = 'error';
             this.storex.transact.msg = errors.response.data.msg; 

        })

    }
/* . . . . . . . . . . . . . . . . . . . */
        },
/* . . . . . . . . . . . . . . . . . . . */
        mounted() {  
            this.loadList();
           this.setRefClients();
           this.setRefCars();
           this.initValuesITEM();
          // console.log('. . . ');
         //  console.log(this.basedata);
            

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


<card-cp title="Localizar aluguel">
    <template v-slot:content>
  
<p v-if="opsearch==false">
  <a class="btn btn-primary" @click="openSearch()">Abrir pesquisa</a>
</p>
<p v-if="opsearch==true">
<button class="btn btn-danger"  @click="openSearch()">Fechar pesquisa</button>
</p>
<div id="collSearch" v-if="opsearch==true">

       <input type="number"  class="form-control mb-2" id="inputID" aria-describedby="idHelp" placeholder="ID" ref="inputID">

  <input type="text" class="form-control mb-2" id="inputPlaca" aria-describedby="Placa"
        placeholder="Placa"  ref="inputPlaca">

     <input type="text" class="form-control mb-2" id="inputModelo" aria-describedby="Modelo"
        placeholder="Modelo do veículo"  ref="inputModelo">

     <input type="text" class="form-control mb-2" id="inputCliente" aria-describedby="Nome do cliente"
        placeholder="Nome do cliente"  ref="inputCliente">

        <div class="input-group input-group-sm mb-3"><span class="input-group-text" id="inputkms">Data inicial</span>
        <input type="date" class="form-control" id="inputDataInicial" ref="inputDataInicial" placeholder="Data inicial"  aria-describedby="Data inicial" >
        </div>

<div class="input-group input-group-sm mb-3">
<span class="input-group-text" id="inputkms">KM inicial&nbsp;&nbsp;
   <select ref="inpSelectKMStart" id="inpSelectKMStart">
   <option value=">=">>=</option> <option value="="> =  </option>
   <option value=">"> >  </option> <option value="<="> <=  </option>
   <option value="<"> <  </option>
   </select>
  </span> 
   <input type="number" class="form-control" id="inputKMStart" ref="inputKMStart" placeholder="KM inicial" aria-describedby="km begin" value="0">
  </div> 

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
<dmodal-cp modalname="modalAdd" title="Adicionar Novo Aluguel">
<template v-slot:alerts> 
<!-- ID,Plate( Ref),Model Ref),Cliente(Ref),cliente_id,carro_id,Daily_Rate,KM_Start,KM_final,data_inicial,End_DATE,FINAL_DATE -->
 <alert-cp stll="success" title="Adicionado com sucesso!" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="Erro na adição de novo aluguel - contate o administrador do sistema" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>  
</template>

    <template v-slot:content> 
    <div class="container-sm">

     <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="clienteX">Cliente</span>
    <select ref="clienteX" class="form-select form-select-sm">
        <option v-for="itt in refclientsCP" :value="itt[0]">{{itt[1]}}</option>
    </select>
    </div>

     <div class="input-group input-group-sm mb-3">
     <span class="input-group-text" id="carroX">Placa</span>
    <select ref="carroX" class="form-select form-select-sm">
        <option v-for="itt in refCarrosCP" :value="itt[0]">{{itt[1]}} - ({{itt[3]}}) - 
        <span v-if="itt[2]==1">(Disponível)</span> <span v-if="itt[2]==0">(Indisponível)</span>
        </option>
    </select>
    </div>

    <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Taxa Diária</span>
    <input type="text" class="form-control" id="taxaDiariaX" ref="taxaDiariaX" placeholder="Taxa diária" 
    aria-describedby="rate"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">KM inicial</span>
    <input type="number" class="form-control" id="kmInicialX" ref="kmInicialX" placeholder="KM inicial" 
    aria-describedby="km inicial" value="0"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Km Final</span>
    <input type="number" class="form-control" id="kmFinalX" ref="kmFinalX" placeholder="km final" 
    aria-describedby="km fim" value="0"></div>
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Data inicial</span>
    <input type="datetime-local" step="2" class="form-control" id="dataInicioX" ref="dataInicioX" placeholder="Data inicial" 
    aria-describedby="Data inicial" ></div>

         <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Data final (esperada)</span>
    <input type="datetime-local" step="2" class="form-control" id="dataFimX" ref="dataFimX" placeholder="End Date Expected" 
    aria-describedby="Date end"></div>

         <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">DATA FINAL (realizada)</span>
    <input type="datetime-local" step="2" class="form-control" id="dataFinalX" ref="dataFinalX" placeholder="Real final Date - Fullfill in return" 
    aria-describedby="final date"></div>

    
    <div class="input-group input-group-sm mt-2 mb-2">
     <span class="input-group-text" id="dailyrateHelp">
     <button type="button" class="btn btn-sm btn-outline-secondary" @click="calcVall()">Calcular a previsão de taxa diária</button>
     </span>
    <input type="text" :value="ratex" size="10">
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
<dmodal-cp modalname="modalView" title="Visualizar aluguel">
       <template v-slot:alerts></template>
       <template v-slot:content> 
   <h4 v-if="storex.item[0].tem_carro!=undefined">{{storex.item[0].tem_carro.placa}}</h4> <hr>

    
<div class="container" v-if="storex.item[0].tem_carro!=undefined">

    <li class="col" >Placa: {{storex.item[0].tem_carro.placa}}</li>
    <li class="col">ID: {{storex.item[0].id}}</li>
    <li class="col">Modelo: {{storex.item[0].veiculo[0].Modelo}} </li>
    <li class="col">Marca: {{storex.item[0].veiculo[0].Marca}} </li>
    <li class="col">Cliente: {{storex.item[0].tem_cliente.nome}} - ID:{{storex.item[0].cliente_id}}</li>
    <li class="col">KM inicial: {{storex.item[0].km_inicial}}</li>
    <li class="col">Km Final: {{storex.item[0].km_final}}</li>

      <li class="col">Taxa Diária : {{storex.item[0].taxa_diaria}}</li>
     <li class="col">Data inicial: {{storex.item[0].data_inicial}}</li>
    <li class="col">Data final esperada: {{storex.item[0].data_final_esperada}}</li>
     <li class="col">Data Final realizada: {{storex.item[0].data_final_realizada}}</li>
  
  

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
 <dmodal-cp modalname="modalUpd" title="Finalizar aluguel">
  <template v-slot:alerts>
    <alert-cp stll="success" title="Este procedimento foi registrado com sucesso!" :details="storex.transact" v-if="storex.transact.status == 'success'">
    </alert-cp>
    <alert-cp stll="danger" title="erro no registro - consulte o administrador do sistema" 
    :details="storex.transact" v-if="storex.transact.status == 'error'">
    </alert-cp>
  </template>

    <template v-slot:content> 
       {{setUpdValues()}} 
     <div v-if="storex.item[0].tem_carro!=undefined">  
       <!-- div v-if="((storex.item[0].data_final_realizada!='2024-01-01 00:00:00')&&(storex.item[0].data_final_realizada!='0000-00-00 00:00:00'))">Este Aluguel foi finalizado!</div -->
    <div class="container-sm">   
   <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Taxa Diária</span>
    <input type="text" class="form-control" ref="updTXDiaria"  placeholder="Taxa diária" 
    v-model="storex.item[0].taxa_diaria"
    aria-describedby="rate"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">KM inicial</span>
    <input type="number" class="form-control" ref="updKMInicial"  placeholder="KM inicial" 
    v-model="storex.item[0].km_inicial"
    aria-describedby="km begin"></div>

     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Km Final</span>
    <input type="number" class="form-control" ref="updKMFinal"  placeholder="km final" 
    v-model="storex.item[0].km_final"
    aria-describedby="km end"></div>
 
     <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Data inicial</span>
    <input type="datetime-local" step="2" class="form-control" ref="updDInicial" 
    v-model="storex.item[0].data_inicial"
     placeholder="Data inicial" aria-describedby="Data inicial" ></div>

         <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Data final (esperada)</span>
    <input type="datetime-local" step="2" class="form-control" ref="updDFEsperada"  placeholder="Data Final esperada" 
    v-model="storex.item[0].data_final_esperada"
    aria-describedby="Date end"></div>

         <div class="input-group input-group-sm mb-1">
     <span class="input-group-text" id="dailyrateHelp">Data Final (realizada)</span>
    <input type="datetime-local" step="2" class="form-control" ref="updDFRealizada" placeholder="Data final realizada - Preenchida no retorno" v-model="storex.item[0].data_final_realizada"
    aria-describedby="final date"></div>

    
    
    <div class="input-group input-group-sm mt-2 mb-2">
     <span class="input-group-text" id="dailyrateHelp">
     <button type="button" class="btn btn-sm btn-outline-secondary" @click="calcVallT2()">Calcular a Taxa diária</button>
     </span>
    <input type="text" :value="ratex" size="10">
    </div>

            
        </div>

        </div>
       </template>

       <template v-slot:footer>
        &nbsp;<button type="button" class="btn btn-primary" @click="updateh()">Finalizar o aluguel</button>
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
<dmodal-cp modalname="modalDel" title="Deletar aluguel">
       <template v-slot:alerts>
           <alert-cp stll="success" title="Deletado com sucesso" :details="storex.transact" v-if="storex.transact.status == 'success'"></alert-cp>
            <alert-cp stll="danger" title="erro no processo de exclusão" :details="storex.transact" v-if="storex.transact.status == 'error'"></alert-cp>
       </template>
       <template v-slot:content> 
       <h4>Deletar um aluguel com o seguinte conteúdo</h4><hr>
       <li> ID: {{storex.item.ID}}</li>
       <li> Placa: {{storex.item.Placa}}</li>
       <li> Modelo: {{storex.item.Modelo}}</li>
       <li> Cliente: {{storex.item.Cliente}}</li>
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
<card-cp title="Lista de alugueis">

    <template v-slot:content>
     <table-cp :dbdatas="basedata"
               :titles="titlesCP"
               :dview="{visible:true, dataTarget:'modalView',title:'Visualizar'}"
               :ddel="{visible:false, dataTarget:'modalDel',title:'Finalizar Aluguel'}"
               :dupd="{visible:false, dataTarget:'modalUpd',title:''}"
               :config="{title:'Operations', amountcolls: 1, refrow:'tem_cliente', refrowII:'tem_carro', refname:'nome', refnameII:'placa', visible:true, typer:'last', imagefield:'Nullable', funvisible:true, funtitle:'Finalizar aluguel',neoFunction:'api/aluguel'}"
              
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




<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
<!-- = = = = = = = =  =  =  =  =  =  =  =  -->
