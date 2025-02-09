<link rel="stylesheet" href="{{ asset('pages/css/host/host-property-create.css') }}">
@extends('layouts.host-layout')

@section('title', 'Host Property Create - HOLISTAY')

@section('content')

<div class="container-create">
    <form action="{{ isset($property) ? route('hostProperty.update', ['id' => $property['property_id']]) : route('hostProperty.store') }}"
        method="POST" enctype="multipart/form-data">

        @csrf

        @if(isset($property))
        @method('PUT')
        @endif

        <h1>{{ isset($property) ? $property['property_name'] : 'Nova Propriedade' }}</h1>
        <div class="form-grid">
            <div class="form-group">
                <!-- Nome da Propriedade -->
                <div class="form-group">
                    <label for="name">Nome da Propriedade:</label>
                    <input type="text" id="name" name="name" value="{{ isset($property) ? $property['property_name'] : '' }}" required class="form-control" placeholder="Nome da propriedade">
                </div>

                <!-- Localidade -->
                <div class="form-group">
                    <label for="location">Localidade:</label>
                    <input type="text" id="location" name="location" value="{{ isset($property) ? $property['property_city'] : '' }}" required class="form-control" placeholder="Localidade">
                </div>

                <!-- País -->
                <div class="form-group">
                    <label for="country">País:</label>
                    <input type="text" id="country" name="country" value="{{ isset($property) ? $property['property_country'] : '' }}" required class="form-control" placeholder="País">
                </div>

                <!-- Endereço -->
                <div class="form-group">
                    <label for="address">Endereço:</label>
                    <input type="text" id="address" name="address" value="{{ isset($property) ? $property['property_address'] : '' }}" required class="form-control" placeholder="Endereço completo">
                </div>

                <!-- Capacidades -->
                <div class="form-capacity">
                    <div class="form-group">
                        <!-- Número de Quartos -->
                        <label for="rooms">Nº de Quartos:</label>
                        <div class="quantity-control">
                            <input type="number" id="rooms" name="rooms" value="{{ isset($property) ? $property['property_bedrooms'] : '' }}" required placeholder="0" class="form-control">
                            <button type="button" class="btn-decrement">-</button>
                            <button type="button" class="btn-increment">+</button>
                        </div>

                        <!-- Número de Camas -->
                        <label for="beds">Nº de Camas:</label>
                        <div class="quantity-control">
                            <input type="number" id="beds" name="beds" value="{{ isset($property) ? $property['property_beds'] : '' }}" required placeholder="0" class="form-control">
                            <button type="button" class="btn-decrement">-</button>
                            <button type="button" class="btn-increment">+</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Capacidade -->
                        <label for="capacity">Capacidade:</label>
                        <div class="quantity-control">
                            <input type="number" id="capacity" name="capacity" value="{{ isset($property) ? $property['property_capacity'] : '' }}" required placeholder="0" class="form-control">
                            <button type="button" class="btn-decrement">-</button>
                            <button type="button" class="btn-increment">+</button>
                        </div>

                        <!-- Número de WCs -->
                        <label for="bathrooms">Nº de WCs:</label>
                        <div class="quantity-control">
                            <input type="number" id="bathrooms" name="bathrooms" value="{{ isset($property) ? $property['property_bathrooms'] : '' }}" required placeholder="0" class="form-control">
                            <button type="button" class="btn-decrement">-</button>
                            <button type="button" class="btn-increment">+</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Politica de cancelamento -->
                        <label for="rooms">Politica de cancelamento (Nº de dias antes da data do check-in):</label>
                        <div class="quantity-control">
                            <input type="number" id="days" name="days" value="{{ isset($property) ? $property['cancellation_policy'] : '' }}" required placeholder="0" class="form-control">
                            <button type="button" class="btn-decrement">-</button>
                            <button type="button" class="btn-increment">+</button>
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea id="description" name="description" class="form-control" required placeholder="Descrição da propriedade">{{ isset($property) ? $property['property_description'] : '' }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <!-- Preço -->
                <div class="form-group">
                    <label for="price">Preço (€ / Dia):</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ isset($property) ? $property['property_price'] : '' }}" required placeholder="0">
                </div>

                <!-- Tipo de Propriedade -->
                <div class="form-group">
                    <label for="property_type">Tipo de Propriedade:</label>
                    <select id="property_type" name="property_type" class="form-control" required>
                        <option value="Studio" {{ isset($property) && $property['property_type'] == 'Studio' ? 'selected' : '' }}>Estúdio</option>
                        <option value="Apartament" {{ isset($property) && $property['property_type'] == 'Apartment' ? 'selected' : '' }}>Apartamento</option>
                        <option value="House" {{ isset($property) && $property['property_type'] == 'House' ? 'selected' : '' }}>Casa</option>
                    </select>
                </div>

                <!-- Comodidades -->
                <div class="form-group">
                    <label>Comodidades:</label>
                    <ul class="amenities-list">
                        @foreach ($amenities as $amenity)
                        <li>
                            <label>
                                <input type="checkbox" name="amenities[]" value="{{ $amenity['amenity_id'] }}"
                                    {{ isset($property) && in_array($amenity['name'], array_column($property['amenities'], 'name')) ? 'checked' : '' }}>
                                <i class="fa fa-{{ $amenity['name'] }}" aria-hidden="true"></i> {{ $amenity['name'] }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Upload de Fotos -->
                <div class="form-group">
                    <label>Fotos:</label>
                    <div id="photo-preview" class="photo-grid"></div>

                    <!-- Botões de Seleção e Remoção de Fotos -->
                    <div class="button-container">
                        <button type="button" id="select-photo-btn" class="btn btn-primary">Adicionar Fotos</button>
                        <button id="remove-photo-btn" class="btn btn-danger" disabled>Remover Foto</button>
                    </div>

                    <!-- Input tipo file oculto para as fotos exibidas na página-->
                    <input type="file" id="photo-input" name="photos[]" value="photos[]" multiple accept="image/*" class="form-control" style="display: none;">
                    <!-- Input tipo file oculto para as fotos removidas -->
                    <input type="hidden" id="removed-photos" name="removed_photos">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-add">
            {{ isset($property) ? 'Atualizar Propriedade' : 'Criar Propriedade' }}
        </button>
    </form>
</div>
@endsection

<!-- Script para gerir as fotos na página -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let photoInput = document.getElementById("photo-input");
        let preview = document.getElementById("photo-preview");
        let removeBtn = document.getElementById("remove-photo-btn");
        let selectPhotoBtn = document.getElementById("select-photo-btn");
        let selectedImage = null;
        let removedPhotos = []; // Armazena os IDs das fotos removidas

        let existingPhotos = @json(isset($property) ? $property['photos'] : []);
        existingPhotos.forEach(photo => {
            let photoUrl = "{{ asset('') }}" + photo.photo_url;
            addPhotoToPreview(photoUrl, photo.photo_id);
        });

        selectPhotoBtn.addEventListener("click", function() {
            photoInput.click();
        });

        photoInput.addEventListener("change", function(event) {
            Array.from(event.target.files).forEach(file => {
                if (file.type.startsWith("image/")) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        addPhotoToPreview(e.target.result, null); // Foto nova não tem ID
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        removeBtn.addEventListener("click", function() {
            if (selectedImage) {
                let confirmDelete = confirm("Tem certeza que deseja excluir esta foto?");
                if (confirmDelete) {
                    let photoId = selectedImage.getAttribute("data-photo-id");
                    if (photoId) {
                        removedPhotos.push(photoId); // Adiciona o ID ao array
                    }
                    preview.removeChild(selectedImage);
                    selectedImage = null;
                    removeBtn.disabled = true;
                    document.getElementById("removed-photos").value = JSON.stringify(removedPhotos);
                }
            }
        });

        function addPhotoToPreview(photoUrl, photoId) {
            let imgContainer = document.createElement("div");
            imgContainer.classList.add("image-container");
            if (photoId) {
                imgContainer.setAttribute("data-photo-id", photoId);
            }

            let img = document.createElement("img");
            img.src = photoUrl;

            img.addEventListener("click", function() {
                document.querySelectorAll(".image-container img").forEach(el => el.classList.remove("selected"));
                img.classList.add("selected");
                selectedImage = imgContainer;
                removeBtn.disabled = false;
            });

            imgContainer.appendChild(img);
            preview.appendChild(imgContainer);
        }
    });
</script>

<!-- Script para gerir os botões de '+' e '-' das capacidades na página -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ---------------------- INCREMENTAR E DECREMENTAR ----------------------
        document.querySelectorAll(".quantity-control").forEach(function(control) {
            let input = control.querySelector("input");
            let btnIncrement = control.querySelector(".btn-increment");
            let btnDecrement = control.querySelector(".btn-decrement");

            btnIncrement.addEventListener("click", function() {
                let currentValue = parseInt(input.value) || 0; // Se estiver vazio ou inválido, assume 0
                input.value = currentValue === 0 ? 1 : currentValue + 1;
            });

            btnDecrement.addEventListener("click", function() {
                let currentValue = parseInt(input.value) || 0;
                if (currentValue > 0) { // Impede valores negativos
                    input.value = currentValue - 1;
                }
            });
        });
    });
</script>
