@extends('layouts.app')

@section('title', 'Event Management Work Brief - RoyalWay Media')

@section('content')

    <!-- Page Header -->

    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">Event Management Work Brief Form</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Brief Form Section -->

    <section class="event-brief-form-section py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <div class="event-brief-form-wrapper">
                        <form class="event-brief-form" id="eventBriefForm" action="{{ route('event-brief.store') }}" method="POST">
                            @csrf

                            <!-- Basic Information -->
                            <div class="form-section mb-5">
                                <h3 class="text-dark mb-4">Basic Information</h3>

                                <div class="mb-4">
                                    <label class="form-label">Name of Organization?<span class="text-danger">*</span></label>
                                    <input type="text" name="organization_name" class="form-control form-control-lg @error('organization_name') is-invalid @enderror" value="{{ old('organization_name') }}" required>
                                    @error('organization_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Key Client Contact?<span class="text-danger">*</span></label>
                                    <input type="text" name="key_contact" class="form-control form-control-lg @error('key_contact') is-invalid @enderror" value="{{ old('key_contact') }}" required>
                                    @error('key_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Preferred Event Venue?<span class="text-danger">*</span></label>
                                    <input type="text" name="venue" class="form-control form-control-lg @error('venue') is-invalid @enderror" value="{{ old('venue') }}" required>
                                    @error('venue')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nature of Event?<span class="text-danger">*</span></label>
                                    <input type="text" name="event_nature" class="form-control form-control-lg @error('event_nature') is-invalid @enderror" value="{{ old('event_nature') }}" required>
                                    @error('event_nature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Event Setup -->
                            <div class="form-section mb-5">
                                <h3 class="text-dark mb-4">Event Setup</h3>

                                <div class="mb-4">
                                    <label class="form-label d-block mb-3">Event set-up preference?<span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="setup" id="indoor" value="indoor" {{ old('setup') == 'indoor' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="indoor">In-door event</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="setup" id="outdoor" value="outdoor" {{ old('setup') == 'outdoor' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="outdoor">Out-door event</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label d-block mb-3">Proposed number of event guests?<span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guest_count" id="less50" value="less50" {{ old('guest_count') == 'less50' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="less50">Less than 50 px</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guest_count" id="50-70" value="50-70" {{ old('guest_count') == '50-70' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="50-70">50-70 px</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guest_count" id="80-100" value="80-100" {{ old('guest_count') == '80-100' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="80-100">80-100 px</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guest_count" id="100-200" value="100-200" {{ old('guest_count') == '100-200' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="100-200">100-200 px</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guest_count" id="250above" value="250above" {{ old('guest_count') == '250above' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="250above">250 and above</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Logistics -->
                            <div class="form-section mb-5">
                                <h3 class="text-dark mb-4">Event Logistics</h3>

                                <div class="mb-4">
                                    <h5 class="text-dark-emphasis mb-3">Venues Setup - Options</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Venue Sourcing" id="venueSourcing">
                                                <label class="form-check-label" for="venueSourcing">Venue Sourcing</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Tents" id="tents">
                                                <label class="form-check-label" for="tents">Tents</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Chairs" id="chairs">
                                                <label class="form-check-label" for="chairs">Chairs</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Cocktail tables" id="cocktailTables">
                                                <label class="form-check-label" for="cocktailTables">Cocktail tables</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Rectangular tables" id="rectangularTables">
                                                <label class="form-check-label" for="rectangularTables">Rectangular tables</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Round tables" id="roundTables">
                                                <label class="form-check-label" for="roundTables">Round tables</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Floor boards" id="floorBoards">
                                                <label class="form-check-label" for="floorBoards">Floor boards</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Stage/Platforms" id="stagePlatforms">
                                                <label class="form-check-label" for="stagePlatforms">Stage/ Platforms</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Podium" id="podium">
                                                <label class="form-check-label" for="podium">Podium</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="venue_setup[]" value="Generator & Fuel" id="generator">
                                                <label class="form-check-label" for="generator">Generator & Fuel</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="text-dark-emphasis mb-3">Sound & Visuals - Options</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Sound/PA Systems" id="soundSystems">
                                                <label class="form-check-label" for="soundSystems">Sound/ PA Systems</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="LED Screens" id="ledScreens">
                                                <label class="form-check-label" for="ledScreens">LED Screens</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Plasma Screens" id="plasmaScreens">
                                                <label class="form-check-label" for="plasmaScreens">Plasma Screens</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Lighting" id="lighting">
                                                <label class="form-check-label" for="lighting">Lighting</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Microphones" id="microphones">
                                                <label class="form-check-label" for="microphones">Microphones</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Comfort Monitor" id="comfortMonitor">
                                                <label class="form-check-label" for="comfortMonitor">Comfort Monitor</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Photography" id="photography">
                                                <label class="form-check-label" for="photography">Photography</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sound_visuals[]" value="Video coverage" id="videoCoverage">
                                                <label class="form-check-label" for="videoCoverage">Video coverage</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="text-dark-emphasis mb-3">Decoration Items</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Seat covers" id="seatCovers">
                                                <label class="form-check-label" for="seatCovers">Seat covers</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Draping" id="draping">
                                                <label class="form-check-label" for="draping">Draping</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Table Linen" id="tableLinen">
                                                <label class="form-check-label" for="tableLinen">Table Linen</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Table Runners" id="tableRunners">
                                                <label class="form-check-label" for="tableRunners">Table Runners</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Flower centerpieces" id="flowerCenterpieces">
                                                <label class="form-check-label" for="flowerCenterpieces">Flower centerpieces</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Carpets" id="carpets">
                                                <label class="form-check-label" for="carpets">Carpets</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="decoration[]" value="Walkways" id="walkways">
                                                <label class="form-check-label" for="walkways">Walkways</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hospitality & Entertainment -->
                            <div class="form-section mb-5">
                                <h3 class="text-dark mb-4">Hospitality & Entertainment</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="Photo Booth" id="photoBooth">
                                            <label class="form-check-label" for="photoBooth">Photo Booth</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="Selfie frame" id="selfieFrame">
                                            <label class="form-check-label" for="selfieFrame">Selfie frame</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="MC/Event Host Sourcing" id="mcHost">
                                            <label class="form-check-label" for="mcHost">MC /Event Host Sourcing</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="Ushers" id="ushers">
                                            <label class="form-check-label" for="ushers">Ushers</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="Live Entertainment Band" id="liveBand">
                                            <label class="form-check-label" for="liveBand">Live Entertainment Band</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="Cultural Drama Group" id="culturalDrama">
                                            <label class="form-check-label" for="culturalDrama">Cultural Drama Group</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hospitality[]" value="Performance Guest Artist" id="guestArtist">
                                            <label class="form-check-label" for="guestArtist">Performance Guest Artist</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Branding & Communication -->
                            <div class="form-section mb-5">
                                <h3 class="text-dark mb-4">Branding & Communication</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="branding[]" value="Media management" id="mediaManagement">
                                            <label class="form-check-label" for="mediaManagement">Media management</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="branding[]" value="Live Streaming" id="liveStreaming">
                                            <label class="form-check-label" for="liveStreaming">Live Streaming</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="branding[]" value="Social Media Event Boosting" id="socialMediaBoosting">
                                            <label class="form-check-label" for="socialMediaBoosting">Social Media Event Boosting</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="branding[]" value="Branded materials" id="brandedMaterials">
                                            <label class="form-check-label" for="brandedMaterials">Branded materials</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="branding[]" value="Awards and Special Gift plaques" id="awards">
                                            <label class="form-check-label" for="awards">Awards and Special Gift plaques</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="form-section mb-5">
                                <h3 class="text-dark mb-4">Additional Information</h3>
                                <div class="mb-4">
                                    <label class="form-label">Any Additional Information</label>
                                    <textarea name="additional_info" class="form-control form-control-lg" rows="5" placeholder="Please provide any additional details about your event">{{ old('additional_info') }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-burgundy btn-lg px-5">Submit Event Brief</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
