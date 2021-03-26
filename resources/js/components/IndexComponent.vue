    <template>
    <div>                   
        <div class="float-left">
            <h1>Books</h1>        				
    	</div>
        <div class="float-right">
        	<button type="button" class="btn btn-success"  @click="addData()">
        	Add New Book
        	</button>
    	</div>
        <div>                      
            <table class="table table-striped table-bordered border-primary text-center">
                <thead>
                    <tr>
                        <th>Date Published</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Action</th>                         
                    </tr>
                </thead>
                
                <tbody>
                    <tr v-for="book in laravelData.data" :key="book.id" >                
                        <td>{{book.datepublished}}</td>
                        <td>{{book.title}}</td>
                        <td>{{book.author}}</td>
                        <td>
                            <button type="button" name="view" class="btn btn-primary btn-sm view-book" @click="viewData(book.id)">View Details</button>
                            <button type="button" name="edit" class="btn btn-primary btn-sm edit-book" @click="editData(book.id)">Edit Book</button>
                            <button type="button" name="delete" class="btn btn-danger btn-sm delete-book" @click="deleteData(book.id)">Delete</button>                                                                                       
                        </td>                    
                    </tr>
                </tbody>
                
            </table>                                              
        </div>  
        <div class="float-left" >
            <paginate
                ref="paginate"                
                :page-count="this.totalPage"
                :page-range="3"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :first-last-button="true">
            </paginate>
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
                                        <label>Created At:</label>
                                        <p><b>{{ infoDtl.created_at }}</b></p>                                        
                                    </div>
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
                                    <form v-on:submit.prevent="onSubmit()">
                                         <div class="form-group" :class="{ 'form-group--error': $v.title.$error }">
                                            <label class="form__label">Title:</label>
                                            <div>
                                                <input type="text" class="form-control" v-model.trim="$v.title.$model" @blur="$v.title.$touch()"/>
                                            </div>
                                            <div class="error" v-if="!$v.title.required && $v.title.$error">Please enter book title.</div>    
                                        </div>

                                        <div class="form-group" :class="{ 'form-group--error': $v.author.$error }">
                                            <label class="form__label">Author:</label>
                                            <div>
                                                <input type="text" class="form-control" v-model.trim="$v.author.$model"  @blur="$v.author.$touch()"/>
                                            </div>
                                            <div class="error" v-if="!$v.author.required  && $v.author.$error">Please enter the name of the author.</div>    
                                        </div>

                                        <div class="form-group" :class="{ 'form-group--error': $v.datepublished.$error }">
                                            <label class="form__label">Date Published:</label>
                                            <div>
                                                <b-form-datepicker id="datepublished" v-model.trim="$v.datepublished.$model" class="mb-2" placeholder="Select date published" 
                                                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                                locale="en"></b-form-datepicker> 

                                                <!--<datepicker :typeable="true" inputClass="form-control" id="datepublished" format="yyyy-MM-dd" :required="true" v-model.trim="$v.datepublished.$model" @blur="$v.datepublished.$touch()"></datepicker>                                                
                                                -->
                                            </div>
                                            <!--<div class="error" v-if="!$v.datepublished.required  && $v.datepublished.$error">Please enter the date when the book was published.</div>    -->
                                        </div>
                                        <div class="form-group mt-4">
                                            <input type="hidden" v-model="book_id" />    
                                            <button type="submit" class="btn submit-book-edit btn-success"  @click="saveData()" 
                                                    v-bind:disabled="$v.title.$invalid || $v.author.$invalid || $v.datepublished.$invalid">Submit</button>
                                        </div>      
                                    </form>                                        
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
                                    <form v-on:submit.prevent="onSubmit()">
                                         <div class="form-group" :class="{ 'form-group--error': $v.title.$error }">
                                            <label class="form__label">Title:</label>
                                            <div>
                                                <input type="text" class="form-control" v-model.trim="$v.title.$model" @blur="$v.title.$touch()"/>
                                            </div>
                                            <div class="error" v-if="!$v.title.required && $v.title.$error">Please enter book title.</div>    
                                        </div>

                                        <div class="form-group" :class="{ 'form-group--error': $v.author.$error }">
                                            <label class="form__label">Author:</label>
                                            <div>
                                                <input type="text" class="form-control" v-model.trim="$v.author.$model"  @blur="$v.author.$touch()"/>
                                            </div>
                                            <div class="error" v-if="!$v.author.required  && $v.author.$error">Please enter the name of the author.</div>    
                                        </div>

                                        <div class="form-group" :class="{ 'form-group--error': $v.datepublished.$error }">
                                            <label class="form__label">Date Published:</label>
                                            <div>
                                                <b-form-datepicker id="datepublished" v-model="datepublished" class="mb-2" placeholder="Select date published" 
                                                                :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                                locale="en"></b-form-datepicker> 

                                                <!--<datepicker :typeable="true" inputClass="form-control" id="datepublished" format="yyyy-MM-dd" :required="true" v-model.trim="$v.datepublished.$model" @blur="$v.datepublished.$touch()"></datepicker> -->                                               
                                            </div>
                                            <!--<div class="error" v-if="!$v.datepublished.required  && $v.datepublished.$error">Please enter the date when the book was published.</div>    -->
                                        </div>
                                        <div class="form-group mt-4">
                                            <input type="hidden" v-model="book_id" />  
                                            <button type="submit" class="btn submit-book-edit btn-success"  @click="submitData()"  
                                                    v-bind:disabled="$v.title.$invalid || $v.author.$invalid || $v.datepublished.$invalid">Submit</button>                                            
                                        </div>      
                                    </form>

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
    import Datepicker from 'vuejs-datepicker';
    
    import { required } from 'vuelidate/lib/validators';

    export default {
        components: {
		    Datepicker
	    },
        

    data () {
        return {
            
            laravelData: {},
            infoDtl: [],
            loading: true,
            errored: false,
            viewBook: false,
            editBook: false,
            addBook: false,
            saveEdit: false,
            saveAdd: false,
            errorDtl: [],
            msg: [],
            deleteBook: false,
            pageNum: 0,
            totalPage: 0,
            currentPage: 0,                        
            title: '',
            author: '',
            datepublished: ''
 
        }
    },

    validations: {
        title: {
            required
        },
        author: {
            required
        },
        datepublished: {
            required
        }
    },
    
    mounted () {
        //this.getPages();        
        this.clickCallback();   
    },

    methods: {              
        getPages: function(){
                axios.get('api/books/pages?page=1')
				.then(response => {
					this.totalPage = response.data.last_page;                    
				});                
        },        
        viewData: function(id) {
            axios
            .get('/api/books/' + id)                                
            .then(response => {                    
                this.errorMsg = response.data.message,
                this.infoDtl = response.data.data,
                this.viewBook = true                            
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
                this.clickCallback(this.currentPage);                                                              
                this.editBook = false;
                this.viewAllBooks = true;
                toast.fire({
                    type: 'success',
                    title: 'Book edited successfully.'
                })            
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
                this.clickCallback()                                                             
                this.addBook = false
                toast.fire({
                    type: 'success',
                    title: 'Book added successfully.'
                })        
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
                this.clickCallback()                                                           
                this.deleteBook = false
                toast.fire({
                    type: 'success',
                    title: 'Book deleted successfully.'
                })                               
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },        
        clickCallback: function(pageNum) {              
            this.getPages();  
            this.currentPage = pageNum;                            
            axios.get('api/books/pages?page=' + pageNum)
				.then(response => {
					this.laravelData = response.data;
			});
        },        
    }     
};
</script>

<style>


input {
  border: 1px solid silver;
  border-radius: 4px;
  background: white;
  padding: 5px 10px;
}

.dirty {
  border-color: #5A5;
  background: #EFE;
}

.dirty:focus {
  outline-color: #8E8;
}

.error {
  color: red;  
}

.error:focus {
  outline-color: #F99;
}
</style>