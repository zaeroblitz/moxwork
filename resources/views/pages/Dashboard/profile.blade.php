@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container mx-auto">
        <div class="grid w-full gap-5 px-10 mx-auto md:grid-cols-12">
            <div class="col-span-12">
                <h2 class="mt-8 mb-1 text-2xl font-semibold text-gray-700">
                    Edit My Profile
                </h2>
                <p class="text-sm text-gray-400">
                    Enter your data Correctly & Properly
                </p>
            </div>
        </div>
    </div>
    <section class="container px-6 mx-auto mt-5">
        <div class="grid gap-5 md:grid-cols-12">
            <main class="col-span-12 p-4 md:pt-0">
                <div class="px-2 py-2 mt-2 bg-white rounded-xl">
                    <form action="{{ route('member.profile.update', [Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    {{-- Photo Profile --}}
                                    <div class="col-span-6">
                                        <div class="flex items-center mt-1">
                                            @if (Auth::user()->user_detail()->first()->photo != NULL)
                                                <img src="{{ Storage::url(Auth::user()->user_detail()->first()->photo) }}" alt="photo-profile" class="rounded-full w-16 h-16">
                                            @else
                                                <span class="inline-block w-16 h-16 overflow-hidden bg-gray-100 rounded-full">
                                                    <svg class="w-full h-full text-gray-300" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </span>
                                            @endif
                                           
                                            <input type="file" accept="image/*" name="photo"
                                            class="px-3 py-2 ml-5 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            
                                            <a type="button"
                                                href="{{ route('member.profile.delete-photo') }}"
                                                class="px-3 py-2 ml-5 text-sm font-medium leading-4 text-red-700 bg-transparent rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                onclick="return confirm('Are you sure want to delete your photo?')">
                                                Delete
                                            </a>

                                            @if ($errors->has('photo'))
                                                <p class="text-red-500 mb-3 text-sm">{{ $errors->first('photo') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Name --}}
                                    <div class="md:col-span-6 lg:col-span-3">
                                        <label for="name" class="block mb-3 font-medium text-gray-700 text-md">Full Name</label>
                                        <input placeholder="Enter your name here.." type="text" name="name" id="name" autocomplete="name"  value="{{ $user->name }}"  required
                                        class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    </div>

                                    {{-- Role --}}
                                    <div class="md:col-span-6 lg:col-span-3">
                                        <label for="role" class="block mb-3 font-medium text-gray-700 text-md">Role</label>
                                        <input placeholder="Enter your role here.." type="text" name="role" id="role" autocomplete="role" value="{{ $user->user_detail->role }}" 
                                        class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    </div>

                                    {{-- Email Address --}}
                                    <div class="md:col-span-6 lg:col-span-3">
                                        <label for="email" class="block mb-3 font-medium text-gray-700 text-md">Email Address</label>
                                        <input placeholder="Enter your email address here.." type="text" name="email" id="email" autocomplete="email" value="{{ $user->email }}" required
                                        class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    </div>

                                    {{-- Contact Number --}}
                                    <div class="md:col-span-6 lg:col-span-3">
                                        <label for="contact_number" class="block mb-3 font-medium text-gray-700 text-md">Contact Number</label>
                                        <input placeholder="Enter your contact number here.." type="number" name="contact_number" id="contact_number" autocomplete="contact_number" value="{{ $user->user_detail->contact_number }}" required
                                        class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    </div>

                                    {{-- Biography --}}
                                    <div class="col-span-6">
                                        <label for="biography" class="block mb-3 font-medium text-gray-700 text-md">Biografi</label>
                                        <textarea placeholder="Enter your biography here.." type="text" name="biography" id="biography" autocomplete="biography" 
                                        class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                            rows="4">{{ $user->user_detail->biography }}</textarea>
                                    </div>

                                    {{-- Experiences --}}
                                    <div class="col-span-6">
                                        <label for="experience" class="block mb-3 font-medium text-gray-700 text-md">My Experience</label>

                                        @forelse ($user_experiences as $key => $item)
                                            <input
                                            placeholder="Enter your experiece here.."
                                            type="text" name="{{ 'experience['.$item->id.']' }}" id="{{ 'experience['.$item->id.']' }}"
                                            autocomplete="{{ 'experience['.$item->id.']' }}" value="{{ $item->experience }}"
                                            class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">

                                            @if ($errors->has('experience'))
                                                <p class="text-red-500 mb-3 text-sm">{{ $errors->first('experience') }}</p>
                                            @endif
                                        @empty
                                            <input
                                            placeholder="Enter your experiece here.."
                                            type="text" name="experience[]" id="experience"
                                            autocomplete="experience"
                                            class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                            <input
                                            placeholder="Enter your experiece here.."
                                            type="text" name="experience[]" id="experience"
                                            autocomplete="experience"
                                            class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                            <input
                                            placeholder="Enter your experiece here.."
                                            type="text" name="experience[]" id="experience"
                                            autocomplete="experience"
                                            class="block w-full py-3 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">

                                            @if ($errors->has('experience'))
                                                <p class="text-red-500 mb-3 text-sm">{{ $errors->first('experience') }}</p>
                                            @endif
                                        @endforelse                                        
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 text-right sm:px-6">
                                <a type="button" href="{{ route('member.dashboard.index') }}" 
                                class="inline-flex justify-center px-4 py-2 mr-4 text-sm font-medium text-gray-700 bg-white border border-gray-600 rounded-lg shadow-sm hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300"
                                onclick="return confirm('Are you want to cancel? Any changes you make will not be saved.')">                                
                                    Cancel
                                </a>
                                <button type="submit" 
                                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                onclick="return confirm('Are you sure want to update your profile?')">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </section>
</main>
@endsection
