<template>
<div>
<!-- The Modal -->
<div :id="modalname" class="ymodal" v-on:click="vvvNoMouse()">
  <div class="ymodal-content" @mouseover="mousein='true'"
    @mouseout="mousein='false'">
    <div class="container">
    <span @click="vvvNoShow()" class="yclose">&times;</span>
    <h5 class="modal-title" :id="modalname">{{title}}</h5>
    <hr>
      
       <slot name="alerts"></slot>  
      <div id="conntt" @click="mousein='true'">
          <slot name="content"></slot>
      </div> 
    </div>
    <button type="button" class="btn btn-secondary" @click="vvvNoShow()">Close</button>
     <slot name="footer"></slot>
  </div>
</div>
</div>




   

</template>
<script>
import { useStore } from '../store/store1'
export default {
     props:['title','modalname','jobj'],
     setup() {
	            const storex = useStore();      
		        return { storex };
	        },
     data() {
            return {
                mousein:'true', 
                mousecon:'true'
            }
        },
     methods:{
         vvvNoShow(){
            let name=this.modalname;
            document.getElementById(name).style.display='none';
             this.storex.transact.status='';
             this.storex.transact.message='';
        },
        vvvNoMouse(){
            if ((this.mousein=='false')){
               this.vvvNoShow();
            }
        },
        
     }
    
}    

 </script>
