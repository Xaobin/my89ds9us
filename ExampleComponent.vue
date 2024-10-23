<script>
   import { useStore } from '../store/store1'
   //import { mystore } from '../app';

   
   //
    export default {
        setup() {
	            const storex = useStore();      
		        return { storex };
	        },
              data(){               
            return {
                partyal:this.storex.transact.status,
                
            };
        },
        methods:{
                setMyss(stt){
                this.storex.transact.status=stt;
                this.storex.setMsg(stt);
                console.log("Status:"+this.storex.transact.status);
                console.log("Message:"+this.storex.transact.msg);
               
            },
        },
        mounted() {
            console.log('Component mounted.');
             //useMainStore.transact.status='Entrada';
             //useMainStore.transact.msg='Entrada no login realizada';     
             //this.storex.setStatus('Three');
                     
        }
            
    }
</script>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body" @click="setMyss('...Enjoy...')">
                        I'm an example component.
                        {{partyal}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


