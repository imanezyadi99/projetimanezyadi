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
                        <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal" data-target="#addStudentModal"><i class="fas fa-plus"></i>Ajouter</button>
                    </div>
                    <div class="card-body">
                        <table  id="datatable" class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</a></th>
                                    <th>Email</a></th>

                                    <th>Role</a></th>

                                    <th style="text-align: center;">Actions</th>
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


                                            <td style="text-align: center;">
                                                <button class="btn btn-link" data-toggle="modal" data-target="#viewModal{{$user->id}}" wire:click="viewStudentDetails({{ $user->id }})"><i class='far fa-eye'></i></button>


                                                <button class="btn btn-link"  data-toggle="modal" data-target="#editModal{{$user->id}}" wire:click="$edit('show-edit-modal', {{ $user->id }})"><i class='far fa-edit'></i></button>

                                                <button class="btn btn-link "  data-toggle="modal" data-target="#deleteStudentModal{{$user->id}}" wire:click="deleteConfirmation({{ $user->id }})"><i class='far fa-trash-alt'></i></button>
                                            </td>
                                        </tr>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" enctype="multipart/form-data">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                    
                                            <div class="modal fade" id="deleteStudentModal{{$user->id}}" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">  <i class="fas fa-exclamation-triangle"></i>Supprimer utilisateur</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pt-4 pb-4">
                                                            <h6>Etes-vous sur de vouloir supprimer cette recette <b>{{$user->name}}</b>? <br>
                                                            Cette opération est irreversible</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>
                                                            <button class="btn btn-sm btn-danger" wire:click="deleteStudentData()">Confirmer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <form action="{{ route('users.update', $user->id) }}" method="POST"  enctype="multipart/form-data">
                                            @method('PATCH')
                                            @csrf
                                            <div class="modal fade " id="editModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Modifier cette utilisateur</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nom" class="form-label">Nom</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email">Email:</label>
                                                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="role">Rôle:</label>
                                                                <select class="form-control" id="role" name="role">
                                                                    <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                                                                    <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>User</option>
                                                                </select>
                                                            </div>
                                                        
                                                      
                                                            
                                                            <!-- Ajoutez d'autres champs ici pour les autres attributs du contact -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                                            <button type="button" class="btn btn-danger" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

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
                                                        <p><strong>Role:</strong> {{ $user->hasRole('admin') ? 'Admin' : 'User' }}</p>

                                                   

                                                  
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


     

    <!-- Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  wire:submit.prevent="store">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="myModalLabel"> Ajouter de l'utilisateur</h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('users.store')}}" method="POST" enctype="multipart/form-data">
                      
        
                        @csrf

                        <div class="form-group row">
                            <label for="nom" class="col-3">Nom</label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nom" class="col-3">Email</label>
                            <div class="col-9">
                                <input type="email" name="email" class="form-control" wire:model="email">
                                @error('email')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Rôle</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>

                                            
                            <!-- Fermer le formulaire ici -->
                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary" >Valider</button>
                                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>
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