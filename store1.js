import { defineStore } from 'pinia'
import { useStorage } from "@vueuse/core";

export const useStore = defineStore({
    id: 'mystore',
    state: () => ({
        item: useStorage('iii', { }),
        transact: useStorage('ttt',{status:'zero',msg:'nothing'})
    }),
    actions: {
        setItem(response) {
            this.item = response
        },
        setStatus(response){
            this.transact.status=response
        },
        setMsg(response){
            this.transact.msg=response
        },
        clearItem() {
            this.item = null
          
        }
    },
    persist: true
});

/*
Utilização no vue, opt api
Antes do export default
import { useStore } from '../store/store1'

No início do script, nível de data, dentro export default
setup() {
	            const storex = useStore();      
		        return { storex };
	        },

 Em métodos:
                this.storex.transact.status=stt;
                this.storex.setMsg(...); 
                this.storex.setStatus(...);     
                this.storex.setItem(...);
                console.log("Status:"+this.storex.transact.status);
                console.log("Message:"+this.storex.transact.msg);       
 Creio 
 Que seja possível utilzar a variável storex dentro do template
 {{storex.algo}}                            
*/