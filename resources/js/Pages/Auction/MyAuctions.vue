<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Lelang Saya</h1>
    
    <!-- Filter dan Pencarian -->
    <div class="mb-6 flex gap-4">
      <input
        type="text"
        v-model="search"
        placeholder="Cari lelang..."
        class="px-4 py-2 border rounded-lg flex-grow"
      />
      <select
        v-model="status"
        class="px-4 py-2 border rounded-lg"
      >
        <option value="">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="completed">Selesai</option>
        <option value="cancelled">Dibatalkan</option>
      </select>
    </div>

    <!-- Daftar Lelang -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="auction in filteredAuctions"
        :key="auction.id"
        class="bg-white rounded-lg shadow-md overflow-hidden"
      >
        <img
          :src="auction.image_url"
          :alt="auction.title"
          class="w-full h-48 object-cover"
        />
        <div class="p-4">
          <h2 class="text-xl font-semibold mb-2">{{ auction.title }}</h2>
          <p class="text-gray-600 mb-2">{{ auction.description }}</p>
          <div class="flex justify-between items-center">
            <span class="text-lg font-bold">Rp {{ formatPrice(auction.current_price) }}</span>
            <span
              :class="{
                'bg-green-100 text-green-800': auction.status === 'active',
                'bg-gray-100 text-gray-800': auction.status === 'completed',
                'bg-red-100 text-red-800': auction.status === 'cancelled'
              }"
              class="px-3 py-1 rounded-full text-sm"
            >
              {{ getStatusText(auction.status) }}
            </span>
          </div>
          <div class="mt-4">
            <Link
              :href="route('auctions.show', auction.id)"
              class="block w-full text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
            >
              Lihat Detail
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
      <Pagination
        :links="auctions.links"
        class="flex gap-2"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  auctions: Object
})

const search = ref('')
const status = ref('')

const filteredAuctions = computed(() => {
  return props.auctions.data.filter(auction => {
    const matchesSearch = auction.title.toLowerCase().includes(search.value.toLowerCase()) ||
                         auction.description.toLowerCase().includes(search.value.toLowerCase())
    const matchesStatus = !status.value || auction.status === status.value
    return matchesSearch && matchesStatus
  })
})

const formatPrice = (price) => {
  return new Intl.NumberFormat('id-ID').format(price)
}

const getStatusText = (status) => {
  const statusMap = {
    active: 'Aktif',
    completed: 'Selesai',
    cancelled: 'Dibatalkan'
  }
  return statusMap[status] || status
}
</script> 