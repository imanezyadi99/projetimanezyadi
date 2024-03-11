@extends('layouts.app')

@section('content')
<div>
    <div class="container mt-5">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="float: center;"><strong>Liste des Utilisateurs</strong></h5>
                      
                        <form action="{{ route('index') }}" method="GET">

                        </form>
                    </div>
                    <div class="card-body">
                        <table  id="datatable" class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</a></th>
                                    <th>Email</a></th>
                                    <th>Role</a></th>


                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td> 
                                                <p class="fw-normal mb-1">{{$user->name}}</p>
                       
                                            
                                            </td>

                                           <td> <p class="fw-normal mb-1">{{$user->email}}</p></td>

                                    
                                           <td>            
                                            <p class="fw-normal mb-1">{{ $user->hasRole('admin') ? 'Admin' : 'User' }}</p>
                                           </td>

                                    

                                         
                                        </tr>
                                    

                              

                                        <form action="{{ route('index', $user->id) }}" method="POST"  enctype="multipart/form-data">
                                            @method('GET')
                                            @csrf
                                            <div class="modal fade " id="viewModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Voir utilisateur</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <p><strong>Nom:</strong> {{ $user->name}}</p>
                                                        <p><strong>Email:</strong> {{ $user->email}}</p>

                                                   

                                                  
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
    
     
                            @endforeach

                                                             
  

                            </tbody>
                          
                          
                        </table>
                    </div>
                   
                </div>
              
            </div>
       
        </div>
    </div>


     

                        </form> 
                </div>
            </div>
        </div>
    </div>

   
   


    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>


    <script>
    
        window.addEventListener('close-modal', () => {
            // Masquer tous les modals
            $('#addStudentModal').modal('hide');
            $('.editModal').modal('hide');
            $('#deleteStudentModal').modal('hide');

        });
    
        window.addEventListener('show-edit-modal', (recipeId) => {
            // Afficher le modal d'édition spécifique en utilisant l'ID du contact
            $('#editModal-' + recipeId).modal('show');
        });
    
        window.addEventListener('show-delete-modal', (recipeId) => {
            // Afficher le modal de suppression spécifique en utilisant l'ID du contact
            $('#deleteStudentModal-' + recipeId).modal('show');
        });
    
        window.addEventListener('show-view-student-modal', () => {
            $('#viewStudentModal').modal('show');
        });
    </script>


    @endpush

    @endsection