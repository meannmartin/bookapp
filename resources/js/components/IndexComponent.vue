<template>
    <div>                   
        <div class="float-left">
            <h1>Book List</h1>        				
    	</div>
        <div class="float-right">
        	<button type="button" class="btn btn-success"  @click="addData()">
        	Add New Book
        	</button>
    	</div>
            
        <div v-if="viewAllBooks">
            <table width="100%" style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px">
                <tr>
                    <th style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 80px;text-align: center">Date Published</th>
                    <th style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 200px;text-align: center">Title</th>
                    <th style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 200px;text-align: center">Author</th>
                    <th style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 200px;text-align: center">Action</th>
                </tr>
                <tr v-for="book in info" :key="book.id" class="book-data" style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px">                
                    <td style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 80px;text-align: center">{{book.datepublished}}</td>
                    <td style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 200px;text-align: center">{{book.title}}</td>
                    <td style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 200px;text-align: center">{{book.author}}</td>
                    <td style="border: 1px solid black;border-collapse: collapse;border-spacing: 5px;padding: 10px;height: 20px;width: 200px;text-align: center">
                        <button type="button" name="view" class="btn btn-primary btn-sm view-book" @click="viewData(book.id)">View Details</button>
                        <button type="button" name="edit" class="btn btn-primary btn-sm edit-book" @click="editData(book.id)">Edit Book</button>
                        <button type="button" name="delete" class="btn btn-danger btn-sm delete-book" @click="deleteData(book.id)">Delete</button>                                                                                       
                    </td>                    
                </tr>
            </table>
        </div>  

        <!-- View Detail -->
        <div v-if="viewBook">
            <transition name="model">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h4 class="modal-title float-left" id="modalLabel">Book Information</h4>
                                    </div>
                                    <div>
                                        <button type="button" class="close float-right" @click="viewBook=false" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>                                    
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Book Title:</label>
                                        <p><b>{{ infoDtl.title }}</b></p>                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Author:</label>
                                        <p><b>{{ infoDtl.author }}</b></p>                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Date Published:</label>
                                        <p><b>{{ infoDtl.datepublished }}</b></p>                                        
                                    </div>
                                    <div class="form-group">
                                        <label>ID:</label>
                                        <p><b>{{ infoDtl.id }}</b></p>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    <!-- END View Details -->

    <!-- Add Book -->
        <div v-if="addBook">
            <transition name="model">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h4 class="modal-title float-left" id="modalLabel">Add Book</h4>
                                    </div>
                                    <div>
                                        <button type="button" class="close float-right" @click="addBook=false" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>                                    
                                </div>
                                <div class="modal-body">
                                    <validation-observer v-slot="{ invalid, handleSubmit }">
                                    <form @submit.prevent="handleSubmit(onSubmit)">
                                        <div class="form-group">
                                            <validation-provider rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                <label for="title">Title</label>
                                                <div class="input-group">
                                                    <input type="text" id="title" name="title" placeholder="Enter Title" class="form-control" v-model="title" />
                                                </div>
                                                <div class="invalid-feedback d-inline-block" v-show="errors">{{ errors[0] }}</div>
                                            </validation-provider>
                                        </div>                                    
                                        <div class="form-group">
                                            <validation-provider rules="required" v-slot="{ dirty, valid, invalid, errors }">                                        
                                                <label for="author">Author:</label>
                                                <div class="input-group">
                                                    <input type="text" id="author" name="author" placeholder="Enter Author" class="form-control" v-model="author" />
                                                </div>
                                                <div class="invalid-feedback d-inline-block" v-show="errors">{{ errors[0] }}</div>
                                            </validation-provider>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="published_date_edit">Date Published:</label>
                                            <input type="date" v-model="datepublished" name="published_date" class="form-control hasDatepicker" data-error="Please enter the date when the book was published." required="" autocomplete="off">
                                            
                                        </div>
                                        
                                        <div class="form-group mt-4">
                                            <input type="hidden" v-model="book_id" />    
                                            <button type="submit" class="btn submit-book-edit btn-success"  @click="saveData()" v-bind:disabled="invalid">Submit</button>
                                        </div>      
                                    </form>    
                                    </validation-observer>                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    <!-- END Add Book -->

    <!-- Edit Book -->
        <div v-if="editBook">
            <transition name="model">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h4 class="modal-title float-left" id="modalLabel">Edit Book</h4>
                                    </div>
                                    <div>
                                        <button type="button" class="close float-right" @click="editBook=false" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>                                    
                                </div>
                                <div class="modal-body">
                                    <validation-observer v-slot="{ invalid, handleSubmit }">
                                        <form @submit.prevent="handleSubmit(onSubmit)">
                                            <div class="form-group">
                                                <validation-provider rules="required" v-slot="{ dirty, valid, invalid, errors }">
                                                    <label for="title">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" id="title" name="title" placeholder="Enter Title" class="form-control" v-model="title" />
                                                    </div>
                                                    <div class="invalid-feedback d-inline-block" v-show="errors">{{ errors[0] }}</div>
                                                </validation-provider>
                                            </div>                                    
                                            <div class="form-group">
                                                <validation-provider rules="required" v-slot="{ dirty, valid, invalid, errors }">                                        
                                                    <label for="author">Author:</label>
                                                    <div class="input-group">
                                                        <input type="text" id="author" name="author" placeholder="Enter Author" class="form-control" v-model="author" />
                                                    </div>
                                                    <div class="invalid-feedback d-inline-block" v-show="errors">{{ errors[0] }}</div>
                                                </validation-provider>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="published_date_edit">Date Published:</label>
                                                <input type="date" v-model="datepublished" name="published_date" class="form-control hasDatepicker" data-error="Please enter the date when the book was published." required="" autocomplete="off">
                                                
                                            </div>
                                            
                                            <div class="form-group mt-4">
                                                <input type="hidden" v-model="book_id" />    
                                                <button type="submit" class="btn submit-book-edit btn-success"  @click="submitData()">Submit</button>
                                            </div>
                                        </form>                                            
                                    </validation-observer>                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    <!-- END Edit Book -->

    <!-- Delete Book -->
        <div v-if="deleteBook">
            <transition name="model">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h4 class="modal-title float-left" id="modalLabel">Delete Book</h4>
                                    </div>                                    
                                </div>
                                <div class="modal-body">
                                    <div class="modal-body text-center">
                                        <input type="hidden" v-model="book_id" />    
                                        <label id="" style="font-size: 16px;">Are you sure you want to delete book record?</label>    
                                    </div>
                                      
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group mt-4">                                        
                                        <button type="button" class="btn btn-danger text-white"  @click="delBook()">Yes</button>
                                        <button type="button" class="btn btn-secondary"  @click="deleteBook=false">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    <!-- END Delete Book -->

    
    </div>                
</template> 

<script>

    export default {
    data () {
        return {
            info: [],
            infoDtl: [],
            loading: true,
            errored: false,
            viewBook: false,
            editBook: false,
            viewAllBooks: true,
            addBook: false,
            saveEdit: false,
            saveAdd: false,
            errorDtl: [],
            msg: [],
            deleteBook: false                 
        }
    },
    
    mounted () {
        axios
        .get('/api/books')

        .then(response => {
            this.info = response.data.data
            // this.success = response.data.success
        })

        .catch(error => {
            console.log(error)
            this.errored = true
        })

        .finally(() => this.loading = false)
    },

    methods: {        
        displayAll: function(){
            axios
            .get('/api/books')

            .then(response => {
                this.info = response.data.data
                // this.success = response.data.success
            })

            .catch(error => {
                console.log(error)
                this.errored = true
            })

            .finally(() => this.loading = false)

        },
        viewData: function(id) {
            axios
            .get('/api/books/' + id)

            .then(response => {
               // console.log(response.data.data)
                this.errorMsg = response.data.message
                this.infoDtl = response.data.data,
                this.viewBook = true
                
            // this.success = response.data.success
        })
        .catch(error => {
            console.log(error)
            this.errored = true
        })
        },
        editData: function(id) {
            axios
            .get('/api/books/' + id)

            .then(response => {
               // console.log(response.data.data)
                this.book_id = response.data.data.id,
                this.title = response.data.data.title,
                this.author = response.data.data.author,
                this.datepublished = response.data.data.datepublished,                            
                this.editBook = true            
        })

        .catch(error => {
            console.log(error)
            this.errored = true
        })
        },
        submitData: function() {
            axios
            .post('/api/books/update/' + this.book_id,
                {
                    "title": this.title,
                    "author": this.author,
                    "datepublished": this.datepublished,
                    "id": this.book_id,
                })

            .then(response => {          
                this.displayAll();                                                              
                this.editBook = false;
                this.viewAllBooks = true;
            // this.success = response.data.success
        })        

        .catch(error => {
            console.log(error)
            this.errored = true
        })
        },
        addData: function() {                       
                this.book_id = '',
                this.title = '',
                this.author = '',
                this.datepublished = null,                            
                this.addBook = true            
        }, 
        saveData: function() {
            axios
            .post('/api/books/store',
                {
                    "title": this.title,
                    "author": this.author,
                    "datepublished": this.datepublished,
                })

            .then(response => {          
                this.displayAll();                                                              
                this.addBook = false;
                this.viewAllBooks = true;
            // this.success = response.data.success
        })        
        .catch(error => {
            console.log(error)
            this.errored = true
        })
        },
        onSubmit: function() {
        console.log('Form has been submitted!');
      },
        deleteData: function(id) {
            axios
            .get('/api/books/' + id)

            .then(response => {
               // console.log(response.data.data)
                this.book_id = response.data.data.id,            
                this.deleteBook = true 
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })            
        },
        delBook: function() {
            axios
            .delete('/api/books/' + this.book_id)
            .then(response => {
               this.displayAll();                                                              
                this.deleteBook = false;
                this.viewAllBooks = true;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })

        } 


    }    
};
</script>