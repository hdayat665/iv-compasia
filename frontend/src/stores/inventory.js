import { defineStore } from 'pinia'
import api from '../axios'

export const useInventoryStore = defineStore('inventory', {
  state: () => ({
    items: [],
    loading: false,
    error: null,
    success: null,
  }),

  actions: {
    // FETCH PRODUCT IDS
    async fetchProductIds() {
      this.loading = true
      this.error = null
      try {
        const res = await api.get('/product/product-id') // GET request
        this.items = res.data
      } catch (err) {
        console.error(err)
        this.error = 'Failed to fetch inventory'
      } finally {
        this.loading = false
      }
    },

    // FETCH ALL ITEMS
    async fetchItems(page = '', productId = '') {
      this.loading = true
      this.error = null
      try {
        const res = await api.get('/product/list', {
          params: { product_id: productId, page: page },
        }) // GET request
        this.items = res.data
      } catch (err) {
        console.error(err)
        this.error = 'Failed to fetch inventory'
      } finally {
        this.loading = false
      }
    },

    // ADD NEW ITEM
    async addItem(item) {
      try {
        const res = await api.post('/products/upload', item, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        this.success = res.data.message
      } catch (err) {
        console.error(err)
        this.error = 'Failed to add item'
      }
    },
  },
})
