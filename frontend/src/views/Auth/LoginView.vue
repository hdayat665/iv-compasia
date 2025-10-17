<template>
  <div class="login-wrapper d-flex justify-content-center align-items-center vh-100">
    <div class="login-card p-5 shadow-sm rounded-4">
      <h2 class="text-center mb-4 fw-bold">Login</h2>
      <form @submit.prevent="submit">
        <div class="form-group mb-3">
          <input
            type="email"
            class="form-control rounded-pill py-2"
            placeholder="Email"
            v-model="form.email"
            required
          />
        </div>
        <div class="form-group mb-4">
          <input
            type="password"
            class="form-control rounded-pill py-2"
            placeholder="Password"
            v-model="form.password"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
          Login
        </button>
      </form>
      <div v-if="error" class="text-danger mt-3 text-center">{{ error }}</div>

      <!-- register modal -->
      <p class="text-center mt-4">
        Don’t have an account?
        <a
          href="#"
          class="text-success fw-semibold"
          data-bs-toggle="modal"
          data-bs-target="#registerModal"
        >
          Register here
        </a>
      </p>
    </div>
  </div>
  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold">Create an Account</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>

        <div class="modal-body px-4 pb-4">
          <form @submit.prevent="submitRegister">
            <div class="mb-3">
              <input
                type="text"
                class="form-control rounded-pill py-2"
                placeholder="Name"
                v-model="formRegister.name"
                required
              />
            </div>
            <div class="mb-3">
              <input
                type="email"
                class="form-control rounded-pill py-2"
                placeholder="Email"
                v-model="formRegister.email"
                required
              />
            </div>
            <div class="mb-4">
              <input
                type="password"
                class="form-control rounded-pill py-2"
                placeholder="Password"
                v-model="formRegister.password"
                required
              />
            </div>
            <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-semibold">
              Register
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { ref, onMounted } from 'vue'

const auth = useAuthStore()

const form = ref({
  email: '',
  password: '',
})

const formRegister = ref({
  name: '',
  email: '',
  password: '',
})

const error = ref(null)

const submit = async () => {
  error.value = null
  try {
    await auth.login(form.value)
  } catch (error) {
    alert(error.message)
    error.value = error.message
  }
}

const submitRegister = async () => {
  error.value = null
  try {
    await auth.register(formRegister.value)
  } catch (error) {
    error.value = error
    console.log(error)
  }
}

</script>

<style scoped>
.login-wrapper {
  background-color: #f0f4f8; /* soft pastel background */
}

.login-card {
  width: 380px;
  background: #ffffff;
  border-radius: 1rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.form-control:focus {
  box-shadow: 0 0 0 0.2rem rgba(168, 230, 207, 0.25);
  border-color: #a8e6cf;
}

.btn-success {
  background-color: #a8e6cf;
  border-color: #a8e6cf;
  color: #fff;
}

.btn-success:hover {
  background-color: #88d9b3;
  border-color: #88d9b3;
}
</style>
