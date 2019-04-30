<template>
    <div>
        <div class="row">
            
        <div class="col-md-9 col-lg-8">
            <h4>Lista contatti</h4>
            <ul class="form-row">
                <li class="list-group-item" v-for="(contact, key) in list" :key="key">
                    {{contact.id}} | {{contact.name}} | {{contact.email}} | {{contact.phone}}
                    <button @click="showContact(contact.id)" class="btn btn-success btn-sm col-sm-1 b1" title="Modifica">M</button>
                    <button @click="deleteContact(contact.id)" class="btn btn-danger btn-sm col-sm-1 b2" title="Cancella">X</button>
                </li>
            </ul>
        </div>
        <div class="col-md-3 col-lg-4">
            <form v-on:submit.prevent="edit ? updateContact(contact.id) : createContact()" v-bind:class="{ edit: edit }">
                <input type="hidden" name="_token" :value="csrf">
                
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input v-model="contact.name" type="text" name="name" placeholder="nome" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input v-model="contact.email" type="text" name="email" placeholder="email" class="form-control">
                </div>

                <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input v-model="contact.phone" type="phone" name="phone" placeholder="telefono" class="form-control">
                </div>

                <div class="form-group">
                <button v-show="!edit" type="submit" class="btn btn-primary">Nuovo contatto</button>
                <button v-show="edit" type="submit" class="btn btn-primary">Aggiorna contatto</button>
                <button v-show="edit" @click.prevent="noUpdate" class="btn btn-secondary">annulla</button>
                </div>

       </form>
           </div>
       </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            edit: false,
            list:[],
            contact:{
                id:'',
                name:'',
                email:'',
                phone:''
                }
        }
    },
    methods: {
        updateContact(id){
            axios.patch('/contact/' + id, {
                id: id,
                name: this.contact.name,
                email: this.contact.email,
                phone: this.contact.phone
            })
            .then( ()=>{
                this.contact.name='';
                this.contact.email='';
                this.contact.phone='';
                this.edit = false;
                this.fetchContactList();
                })
            .catch( (err)=>{
                    if(err){throw err}
                })
        },

        createContact(){
            axios.post('/contact/store', {
                name: this.contact.name,
                email: this.contact.email,
                phone: this.contact.phone
            })
            .then( ()=>{
                this.contact.name='';
                this.contact.email='';
                this.contact.phone='';
                this.edit = false;
                this.fetchContactList();
                })
            .catch( (err)=>{
                    if(err){throw err}
                })
        },

        fetchContactList(){
            console.log('Fetching contact...');
            axios.get('/contacts').then( (response)=>{
                this.list = response.data;
                console.log(response.data);
                }).catch( (err)=>{
                    console.log(err);
            });
        },

        showContact(id){
            axios.get('/contact/' + id)
                .then( (response) => {
                    this.edit = true;
                    this.contact.id = response.data.id;
                    this.contact.name = response.data.name;
                    this.contact.email = response.data.email;
                    this.contact.phone = response.data.phone;

                }).catch( (err)=>{
                    console.log(err);
            });
        },
        deleteContact(id){
            if(confirm('confermi la cancellazione?'))
             axios.delete('/contact/' + id)
             .then( (response) => {
                this.fetchContactList();
             }).catch( (err)=>{
                    console.log(err);
            });
        },
        noUpdate(){
            this.contact.name='';
            this.contact.email='';
            this.contact.phone='';
            this.edit = false;
        }
    },

    mounted() {
        this.fetchContactList();
        }
}

</script>

<<style>
.form-row{
    padding-left: 0;
}
.btn-sm, .btn-group-sm > .btn {
    padding: 0.1rem 0.2rem;
    font-size: 0.6rem;
}
form{
    padding: 22px;
    transition: 1s;
}
.edit{
    background: #38c172;
    transition: 1s;
}
li {
    font-size: 0.9em;
    width: 100%;
}

.b1{
    position: absolute;
    right: 3px;
    width: 20px;
    top: 3px;
    height: 18px;
}
.b2 {
    position: absolute;
    right: 3px;
    width: 20px;
    top: 24px;
    height: 18px;
}

</style>