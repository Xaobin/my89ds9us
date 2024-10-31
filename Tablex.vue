<script>
import { useStore } from '../store/store1'

export default {
        props: ['dbdatas', 'titles','config', 'dview','dupd','ddel','dfunc'],
        setup() {
	            const storex = useStore();      
		        return { storex };
	        },
          data() {
            return {
                openmodal:'false',
                mousein:'true'
            }
        },
        methods:{
            setStore(obij){
                this.initConfig(obij);
               let mdname=this.dview.dataTarget; 
                document.getElementById(mdname).style.display='block';

              
            },
         setStoreUpd(obij){
                this.initConfig(obij);
               let mdname=this.dupd.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
        setStoreDel(obij){
                this.storex.setItem(obij);
               let mdname=this.ddel.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
         /* . . . . . . . . . . . . . . . . . . . */
        initConfig(tobj){
           
            
               if (this.config.neoFunction!=undefined){
                    console.log('ooooooooooo');
                    console.log(this.config.neoFunction);                
                    this.setSpecificValue(tobj);
               }
               else{
                this.storex.setItem(tobj);
               }
        },
        /* . . . . . . . . . . . . . . . . . . . */
       setSpecificValue(itt){
            let idd=0;
            
            let urlI="";
            if (itt.id!=undefined){ idd=itt.id; }
            if (itt.ID!=undefined){ idd=itt.ID; }
            if (itt.Id!=undefined){ idd=itt.Id; }
            let urla=window.location.host;
            if (urla.search('127.0.0.1')!=-1){
                 urlI="http://127.0.0.1:8000/"+this.config.neoFunction+"/"+idd;
            }
            else{
                 urlI=window.location.protocol+'://'+window.location.host+'/'+this.config.neoFunction+"/"+idd; 
            }
            console.log('aaaaaa');
            console.log(urlI);
            let config = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }
            
            axios.get(urlI, config)
                .then(response => {
                    this.storex.setItem(response.data);
                    
                })
                .catch(errors => {
                    console.log(errors)
                });
               
   },  
            
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
            numberTitles(){
              let cc=0; let arr=[];
              let ttf =this.titles;
                for (const property in ttf) {
                  //console.log(property+".."+ttf[property].ordershow);
                  cc++;
                  if (ttf[property].visible==true){
                    arr.push(cc);
                  }
                }
              //console.log("------");
              //arr.forEach((ell)=>{ console.log(ell); })
                return arr;
            },
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = =              
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = = 
        titlesCP(){
            let neotitles=[];
            let ttt=this.titles;
           

            Object.entries(ttt).forEach(([kk,vv])=> {
                
                if (vv.visible==true){ 
                   
                    neotitles.push(vv); 
                }
               
            });
            return neotitles;
        },
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = =              
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = = 
        
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = =              
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = = 
        filterDatasII(){
         let neovar=[];
         let elem={};
         var nid=0;
         let titlefields = Object.keys(this.titles);
        //console.log(titlefields);
        this.dbdatas.forEach(jobj => {
        Object.entries(jobj).forEach(([khey, vall]) => {
            
            const inkey = titlefields.includes(khey);
            if (inkey==true){
            titlefields.forEach((kk,ii)=>{ 
             
             
                let ttt=this.titles[kk].title;
                let keyy=khey.toLowerCase();
                let kkl=kk.toLowerCase();
                
                if ((keyy==kkl)&&(ii==0)){
                    nid=vall; elem[ttt]=vall;
                }    
                if ((keyy==kkl)&&(ii>0)&&(keyy!=this.config.refrow)&&(keyy!=this.config.refrowII)){
                    elem[ttt]=vall;
                }
                if ((keyy==kkl)&&(ii>0)&&(keyy==this.config.refrow)){  
                    elem[ttt]=vall[this.config.refname];
                    
                }
                if ((keyy==kkl)&&(ii>0)&&(keyy==this.config.refrowII)){
                    //console.log(keyy+'__'+this.config.refrowII);
                    elem[ttt]=vall[this.config.refnameII];
                   
                }
              
                                
            });          
          }
        
        });
        ///*
        let tmp=nid;
        let lele=this.config.amountcolls;
        for (var i = 1; i <= lele; i++) {
            elem['nid']=nid;    
            if (i>1){ elem['nid'+i]=nid; }
        }    
        //console.log(elem);
         neovar.push(elem);
                elem={};
                nid=0;
           
    });
  //  neovar.forEach((ell)=>{ console.log(ell); })
            return neovar;  

     }
// = =  = =  = =  = =  = =  = =  = =  = =  = =  = =  = =     
  
// - - - - - - - - - - - - - - - - - -                     
        },
// - - - - - - - - - - - - - - - - - -        
mounted() {
    //this.datasUM();
    //console.log('Titles cp');
    //console.log(this.titlesCP);
   //this.titlesCP
   // console.log('DB datas');
   // console.log(this.dbdatas);
    
},        
// - - - - - - - - - - - - - - - - - -        
}
// - - - - - - - - - - - - - - - - - -     
/*
Object.keys(obj) = [ "ID", "Name", "Image", "Doors", "Brand", "nid" ] 
Object.keys(titles)=[ "id", "name", "image", "doors", "ref_car_brand", "config" ] 
titles.title = [ "ID", "Name", "Image", "Doors", "Brand", "Operations"

titlefieldsII = id - 0 name - 1 image - 2 doors - 3 ref_car_brand - 4 config - 5 

keyValue = ID Brand_id, Image...
*/
</script>




<template>
    <div>

    <table class="table table-hover">
         <thead>
         <tr>
          <th v-for="t, key in titlesCP" :key="key">
            <span  v-if="t.visible==true">
             {{t.title}}
           </span>  
         </th>
          
      
        </tr>
        </thead>

        <tbody>
         <tr v-for="objA, keyx in filterDatasII" :key="keyx">
          <td v-for="numb in numberTitles">

            <span v-for="tt, kk in titles" :key="kk">
              <span v-for="value, keyValue in objA" :key="keyValue">
                <span v-if="((tt.ordershow==numb)&&(tt.visible==true)&&(tt.title==keyValue)&&(config.imagefield!=keyValue))">{{value}}</span>

                <span v-if="((tt.ordershow==numb)&&(tt.visible==true)&&(tt.title==keyValue)&&(config.imagefield==keyValue))"><img :src="'/'+value" width="30" height="30"></span>
                
              </span>
            </span>
          </td>

          <td v-if="config.visible==true"><span>
            <a type="button" v-if="dview.visible"  @click="setStore(objA)"
            class="btn btn-sm btn-outline-secondary"><span v-if="dview.title!=undefined">{{dview.title}}</span><span v-else>View</span></a>

            <a type="button" v-if="dupd.visible"  @click="setStoreUpd(objA)"
            class="btn btn-sm btn-outline-secondary"><span v-if="dupd.title!=undefined">{{dupd.title}}</span><span v-else>Upd</span></a>

            <a type="button" v-if="config.funvisible"  @click="setStoreUpd(objA)"
            class="btn btn-sm btn-outline-danger">{{config.funtitle}}</a>

            <a type="button" v-if="ddel.visible"  @click="setStoreDel(objA)"
            class="btn btn-sm btn-outline-secondary"><span v-if="ddel.title!=undefined">{{ddel.title}}</span><span v-else>Del</span></a>
            </span>
          </td>
                        
        </tr>
        </tbody>
        </table>


</div>
</template>
