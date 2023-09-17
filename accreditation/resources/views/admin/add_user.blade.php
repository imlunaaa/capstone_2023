<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>
    <div class="py-12">
            @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container-fluid px-4 my-3">
            <form method="POST" action="{{ route('add_user') }}" class="p-4 mx-5">
                @csrf
                <div>
                    <label for="firstname" class="form-label">Firstname</label>
                    <input id="firstname" class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" value="{{ old('firstname') }}" autofocus style="border-radius: 5px">
                    <div id="firstnameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem;">
                        @error('firstname') Please enter a firstname. @enderror
                    </div>
                </div>


                <div>
                    <label for="lastname">Lastname</label>
                    <input id="lastname" class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" value="{{ old('lastname') }}" autofocus style="border-radius: 5px">
                    <div id="lastnameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem;">
                        @error('lastname') Please enter a lastname. @enderror
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <label for="campus" class="form-label">Campus</label>
                    <select name="campus" class="form-select">
                        <option selected disabled>Select Campus</option>
                        @forelse($campuses as $campus)
                        <option value="{{$campus->id}}">{{$campus->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div style="margin-top: 1rem;">
                    <label for="Program">Program</label>
                    <select name="program" class="form-select">
                        <option selected disabled>Select Program</option>
                        @forelse($programs as $program)
                        <option value="{{$program->id}}">{{$program->program}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="form-group py-2">
                    <div class="form-check">
                        <input type="checkbox" id="areachair" name="areachair" value="1" class="form-check-input">
                        <label for="areachair" class="form-check-label">Area Chair</label>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" id="areamember" name="areamember" value="1" class="form-check-input">
                        <label for="areamember" class="form-check-label">Area Member</label>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" id="external" name="external" value="1" class="form-check-input">
                        <label for="external" class="form-check-label">External</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="internal" name="internal" value="1" class="form-check-input">
                        <label for="internal" class="form-check-label">Internal</label>
                    </div>

                </div>

                <div style="margin-top: 1rem;">
                    <label for="email">Email</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" style="margin-top: 0.25rem; width: 100%;" type="email" name="email" value="{{ old('email') }}">
                    <div id="emailError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem;">
                        @error('email') Please enter a email address. @enderror
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <label for="password">Password</label>
                    <input id="password" class="form-control @error('password') is-invalid @enderror" style="margin-top: 0.25rem; width: 100%;" type="password" name="password">
                    <div id="passError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem;">
                        @error('password') Please enter a password. @enderror.
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" style="margin-top: 0.25rem; width: 100%;" type="password" name="password_confirmation" >
                    <div id="cpassError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem;">
                        @error('password_confirmation') Please enter a password. @enderror
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                    <button style="margin-left: 0.5rem; padding: 0.5rem 1rem; background-color: #6366F1; color: #FFF; border: none; border-radius: 0.375rem; cursor: pointer;">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    const form = document.getElementById('registrationForm');
    const firstnameInput = document.getElementById('firstname');
    const firstnameError = document.getElementById('firstnameError');
    const lastnameInput = document.getElementById('lastname');
    const lastnameError = document.getElementById('lastnameError');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const passInput = document.getElementById('password');
    const passError = document.getElementById('passError');
    const cpassInput = document.getElementById('password_confirmation');
    const cpassError = document.getElementById('cpassError');

    // Add event listener to trigger validation on focus out
    firstnameInput.addEventListener('blur', () => {
        validateFirstname();

    });
    lastnameInput.addEventListener('blur', () => {
        validateLastname();
        
    });
    emailInput.addEventListener('blur', () => {
        validateEmail();
        
    });
    passInput.addEventListener('blur', () => {
        validatePass();
        
    });
    cpassInput.addEventListener('blur', () => {
        validateCpass();
        
    });

    // Add event listener to trigger validation on form submission
    form.addEventListener('submit', (event) => {
        if (!validateFirstname() || !validateLastname() || !validateEmail() || !validatePass() ||
!validateCpass()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function validateFirstname() {
        const firstnameValue = firstnameInput.value.trim();

        if (firstnameValue === '') {
            firstnameInput.style.borderColor = 'red'; // Change border color to red
            firstnameError.style.display = 'block'; // Show error message
            firstnameError.innerHTML = "<p>Please enter a firstname</p>";

            return false;
        }

        // Clear any existing error message or class
        firstnameInput.style.borderColor = '#ccc'; // Reset border color
        firstnameError.style.display = 'none'; // Hide error message
        return true;
    }
    function validateLastname() {
        const lastnameValue = lastnameInput.value.trim();

        if (lastnameValue === '') {
            lastnameInput.style.borderColor = 'red'; // Change border color to red
            lastnameError.style.display = 'block'; // Show error message
            lastnameError.innerHTML = "<p>Please enter a lastname</p>";
            return false;
        }

        // Clear any existing error message or class
        lastnameInput.style.borderColor = '#ccc'; // Reset border color
        lastnameError.style.display = 'none'; // Hide error message
        return true;
    }
    function validateEmail() {
        const value = emailInput.value.trim();

        if (value === '') {
            emailInput.style.borderColor = 'red'; // Change border color to red
            emailError.style.display = 'block'; // Show error message
            emailError.innerHTML = "<p>Please enter a email address</p>";

            return false;
        }

        // Clear any existing error message or class
        emailInput.style.borderColor = '#ccc'; // Reset border color
        emailError.style.display = 'none'; // Hide error message
        return true;
    }

    function validatePass() {
        const value = passInput.value.trim();

        if (value == '') {
            passInput.style.borderColor = 'red'; // Change border color to red
            passError.style.display = 'block'; // Show error message
            passError.innerHTML = "<p>Please enter a password</p>";
            return false;
        }
        if (value.length < 6) {
            passInput.style.borderColor = 'red'; // Change border color to red
            passError.style.display = 'block'; // Show error message
            passError.textContent = 'Password must be atleast 6 characters long';
            return false;
        }

        // Clear any existing error message or class
        passInput.style.borderColor = '#ccc'; // Reset border color
        passError.style.display = 'none'; // Hide error message
        return true;
    }
    function validateCpass() {
        const value = cpassInput.value.trim();
        const value2 = passInput.value.trim();

        if (value == '') {
            cpassInput.style.borderColor = 'red'; // Change border color to red
            cpassError.style.display = 'block'; // Show error message
            cpassError.innerHTML = "<p>Please enter a password</p>";

            return false;
        }
        if (value != value2) {
            cpassInput.style.borderColor = 'red'; // Change border color to red
            cpassError.style.display = 'block'; // Show error message
            cpassError.textContent = 'Password does not match';
            return false;
        }

        // Clear any existing error message or class
        cpassInput.style.borderColor = '#ccc'; // Reset border color
        cpassError.style.display = 'none'; // Hide error message
        return true;
    }

    // Add similar validation functions for other fields as needed
</script>

