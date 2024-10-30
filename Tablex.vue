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
                mousein:'true',
                jobj:{}
            }
        },
        methods:{
            setStore(obj){
               
                this.storex.setItem(obj);
               let mdname=this.dview.dataTarget; 
                document.getElementById(mdname).style.display='block';
               // console.log('Item armazenado:')
              //  console.log(this.storex.item);
            },
         setStoreUpd(obj){
                this.storex.setItem(obj);
               let mdname=this.dupd.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
        setStoreDel(obj){
                this.storex.setItem(obj);
               let mdname=this.ddel.dataTarget; 
                document.getElementById(mdname).style.display='block';
            },
        datasUM(){
            let neovar=[];
            var nid=0;
            console.log('_____---_____');
            let titlefields = Object.keys(this.titles);
           // console.log(titlefields);
             console.log('_____---_____');
            this.dbdatas.forEach(kobj=>{
                Object.entries(kobj).forEach(([keyy, vaoo]) => {
                    
                    

            });
            });
        }
            
    },

        computed: {
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
    this.datasUM();
    //console.log('neoTitles');
   // console.log(this.titlesCP);
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
         <tr v-for="obj, keyx in filterDatasII" :key="keyx">
          <td v-for="numb in numberTitles">

            <span v-for="tt, kk in titles" :key="kk">
              <span v-for="value, keyValue in obj" :key="keyValue">
                <span v-if="((tt.ordershow==numb)&&(tt.visible==true)&&(tt.title==keyValue)&&(config.imagefield!=keyValue))">{{value}}</span>

                <span v-if="((tt.ordershow==numb)&&(tt.visible==true)&&(tt.title==keyValue)&&(config.imagefield==keyValue))"><img :src="'/'+value" width="30" height="30"></span>
                
              </span>
            </span>
          </td>

          <td v-if="config.visible==true"><span>
            <a type="button" v-if="dview.visible"  @click="setStore(obj)"
            class="btn btn-sm btn-outline-secondary">View</a>

            <a type="button" v-if="dupd.visible"  @click="setStoreUpd(obj)"
            class="btn btn-sm btn-outline-secondary">Update</a>

            <a type="button" v-if="config.funvisible"  @click="setStoreUpd(obj)"
            class="btn btn-sm btn-outline-danger">{{config.funtitle}}</a>

            <a type="button" v-if="ddel.visible"  @click="setStoreDel(obj)"
            class="btn btn-sm btn-outline-secondary">Delete</a></span>
          </td>
                        
        </tr>
        </tbody>
        </table>


</div>
</template>
