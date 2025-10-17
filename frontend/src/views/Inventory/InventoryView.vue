<template>
  <div class="container py-4">
    <h2 class="mb-4 text-center">Inventory List</h2>

    <!-- upload button -->
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="submit" class="d-flex gap-2 align-items-center">
          <!-- File Input -->
          <input
            type="file"
            @change="handleFile"
            accept=".xlsx"
            class="form-control"
          />

          <!-- Upload Button -->
          <button type="submit" class="btn btn-success">
            {{ 'Upload' }}
          </button>
        </form>

        <!-- Success/Error Messages -->
        <div v-if="success" class="text-success mt-3 text-center">
          {{ success }}
        </div>
        <div v-if="error" class="text-danger mt-3 text-center">
          {{ error }}
        </div>
      </div>
    </div>

    <!-- search -->
    <div class="mb-3">
      <div class="row justify-content-end">
        <div class="col-md-2">
          <input
            type="text"
            v-model="selectedProductId"
            placeholder="Search Product ID"
            class="form-control mb-2"
            @keyup.enter="filterInventory"
          />
        </div>
      </div>
    </div>

    <!-- table -->
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-success">
          <tr>
            <th>Product ID</th>
            <th>Types</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Capacity</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in inventory" :key="item.product_id">
            <td>{{ item.product_id }}</td>
            <td>{{ item.types }}</td>
            <td>{{ item.brand }}</td>
            <td>{{ item.model }}</td>
            <td>{{ item.capacity }}</td>
            <td>{{ item.quantity }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- pagination -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        Showing {{ inventorys.items.from || 0 }} to {{ inventorys.items.to || 0 }} of
        {{ inventorys.items.total || 0 }} entries
      </div>
      <div class="d-flex align-items-center gap-2">
        <button
          class="btn btn-sm btn-primary"
          :disabled="!prevPageUrl"
          @click="goToUrl(prevPageUrl)"
        >
          Previous
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          class="btn btn-sm btn-primary"
          :disabled="!nextPageUrl"
          @click="goToUrl(nextPageUrl)"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useInventoryStore } from '@/stores/inventory'
import { ref, onMounted } from 'vue'

const inventorys = useInventoryStore()
const inventory = ref([])
const selectedProductId = ref('')
const selectedFile = ref(null)
const error = ref(null)
const success = ref(null)

const currentPage = ref(1)
const totalPages = ref(1)
const nextPageUrl = ref(null)
const prevPageUrl = ref(null)
const lastPageUrl = ref(null)
const firstPageUrl = ref(null)

const fromEntry = ref(0)
const toEntry = ref(0)
const totalEntries = ref(0)

const handleFile = (event) => {
  selectedFile.value = event.target.files[0]
}

const submit = async () => {
  error.value = null
  if (!selectedFile.value) return

  try {
    const formData = new FormData()
    formData.append('file', selectedFile.value)

    await inventorys.addItem(formData)
    success.value = inventorys.success
    fetchPage(1)
  } catch (err) {
    error.value = err
  }
}

onMounted(async () => {
  await inventorys.fetchItems()

  inventory.value = inventorys.items.data

  currentPage.value = inventorys.items.current_page
  totalPages.value = inventorys.items.last_page

  nextPageUrl.value = inventorys.items.next_page_url
  prevPageUrl.value = inventorys.items.prev_page_url
  lastPageUrl.value = inventorys.items.last_page_url
  firstPageUrl.value = inventorys.items.first_page_url

  fromEntry.value = inventorys.items.from || 0
  toEntry.value = inventorys.items.to || 0
  totalEntries.value = inventorys.items.total || 0
})

const goToUrl = (url) => {
  if (!url) return
  const params = new URL(url).searchParams
  const page = parseInt(params.get('page')) || 1
  fetchPage(page)
}

const fetchPage = async (page) => {
  await inventorys.fetchItems(page, selectedProductId.value)

  inventory.value = inventorys.items.data
  currentPage.value = inventorys.items.current_page
  totalPages.value = inventorys.items.last_page

  nextPageUrl.value = inventorys.items.next_page_url
  prevPageUrl.value = inventorys.items.prev_page_url
  lastPageUrl.value = inventorys.items.last_page_url
  firstPageUrl.value = inventorys.items.first_page_url

  fromEntry.value = items.from || 0
  toEntry.value = items.to || 0
  totalEntries.value = items.total || 0
}

const filterInventory = async () => {
  await inventorys.fetchItems(1, selectedProductId.value)
  inventory.value = inventorys.items.data
}
</script>

<style scoped>
.login-wrapper,
.container {
  background-color: #f0f4f8; /* soft pastel background */
}

.table th,
.table td {
  vertical-align: middle;
}

.btn-success {
  background-color: #48987a;
  border-color: #a8e6cf;
  color: #fff;
}

.btn-success:hover {
  background-color: #88d9b3;
  border-color: #88d9b3;
}

.form-control:focus {
  box-shadow: 0 0 0 0.2rem rgba(168, 230, 207, 0.25);
  border-color: #a8e6cf;
}
</style>
