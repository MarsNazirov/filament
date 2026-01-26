<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

// Принимаем товары от контроллера
defineProps({
    products: Object
});

// Функция удаления
const deleteProduct = (id) => {
    if (confirm('Вы действительно хотите удалить этот товар?')) {
        // Мы используем router.delete от Inertia
        // Он отправит запрос, а потом сам обновит таблицу
        router.delete(`/api/products/${id}`, {
            onSuccess: () => {
                // Если всё ок, можно показать алерт или просто обновить
                // Inertia сделает перезагрузку данных сама
            },
            onError: (errors) => {
                console.log(errors);
                alert('Ошибка при удалении. Проверьте консоль.');
            }
        });
    }
};
</script>

<template>
    <Head title="Товары" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Каталог товаров</h2>
                <!-- Кнопка добавления (пока не работает, сделаем позже) -->
                <Link href="/products/create" class="bg-blue-600 ...">
                    + Добавить товар
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Категория</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50">
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ product.id }}</td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ product.description }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="product.category" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ product.category.name }}
                                            </span>
                                            <span v-else class="text-gray-400 text-xs">Нет</span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                            {{ product.price }} ₽
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <!-- Ссылка на редактирование (пока заглушка) -->
                                            <Link :href="`/products/${product.id}/edit`" class="text-indigo-600 ...">
                                                Ред.
                                            </Link>
                                            
                                            <!-- КНОПКА УДАЛЕНИЯ -->
                                            <button 
                                                @click="deleteProduct(product.id)"
                                                class="text-red-600 hover:text-red-900 font-bold cursor-pointer"
                                            >
                                                Удалить
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Пагинация -->
                        <div class="mt-6 flex justify-center">
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <template v-for="link in products.links">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                        :class="{ 'z-10 bg-indigo-600 text-white': link.active, 'text-gray-900': !link.active }"
                                    />
                                    <span v-else v-html="link.label" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-400 ring-1 ring-inset ring-gray-300"></span>
                                </template>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>