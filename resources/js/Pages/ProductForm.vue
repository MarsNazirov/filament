<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

// Принимаем данные: categories (всегда), product (только при редактировании)
const props = defineProps({
    categories: Array,
    product: {
        type: Object,
        default: null
    }
});

// Определяем: мы редактируем или создаем?
const isEditing = !!props.product;

// Настраиваем форму (Inertia useForm)
const form = useForm({
    name: props.product ? props.product.name : '',
    description: props.product ? props.product.description : '',
    price: props.product ? props.product.price : '',
    category_id: props.product ? props.product.category_id : '',
});

// Функция отправки
const submit = () => {
    if (isEditing) {
        // Обновление (PUT)
        form.put(`/api/products/${props.product.id}`);
    } else {
        // Создание (POST)
        form.post('/api/products');
    }
};
</script>

<template>
    <Head :title="isEditing ? 'Редактирование' : 'Новый товар'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isEditing ? 'Редактировать товар' : 'Добавить новый товар' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <!-- Название -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Название</label>
                            <input v-model="form.name" type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                            <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <!-- Категория -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Категория</label>
                            <select v-model="form.category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="" disabled>Выберите категорию</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                    {{ cat.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.category_id" class="text-red-600 text-sm mt-1">{{ form.errors.category_id }}</div>
                        </div>

                        <!-- Цена -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Цена</label>
                            <input v-model="form.price" type="number" step="0.01" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required />
                            <div v-if="form.errors.price" class="text-red-600 text-sm mt-1">{{ form.errors.price }}</div>
                        </div>

                        <!-- Описание -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Описание</label>
                            <textarea v-model="form.description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="3"></textarea>
                            <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</div>
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end gap-4">
                            <Link href="/dashboard" class="text-gray-600 hover:text-gray-900 underline text-sm">Отмена</Link>
                            
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="form.processing">
                                {{ isEditing ? 'Сохранить' : 'Создать' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>