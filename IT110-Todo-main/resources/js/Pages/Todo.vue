<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';

defineProps({
  todos: Object,
});

const form = reactive({
  content: null,
});

function submit() {
  if (form.content != null) {
    Inertia.post('/todos', form);
    form.content = null;
  }
}
function updateStatus(todo) {
  Inertia.put('/todos/' + todo.id + '/update');
}

function deleteTodo(todo){
    Inertia.delete('/todos/' + todo.id);
}
</script>


<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Todo
      </h2>
    </template>

    <div class="h-100 w-full flex items-center justify-center bg-teal-lightest font-sans">
      <div class="bg-white rounded shadow p-6 m-4 w-full lg:w-3/4 lg:max-w-lg">
        <div class="mb-4">
          <h1 class="text-grey-darkest">Todo List</h1>
          <div class="flex mt-4">
            <input
              class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"
              placeholder="Add Todo"
              v-model="form.content"
            />
            <button
              class="flex-no-shrink p-2 border-2 rounded text-teal border-teal hover:text-white-300 hover:bg-green-500"
              @click="submit"
            >
              Add
            </button>
          </div>
        </div>

        <div class="flex mb-4 items-center" v-for="todo in todos" :key="todo.id">
          <p class="w-full text-grey-darkest">{{ todo.content }}</p>
          <button v-if="todo.is_done"
            class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded text-black border-green hover:text-white-500 hover:bg-blue-500" 
          >
            Done
          </button>
          <button v-else
            class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded text-black border-green hover:text-white-500 hover:bg-red-500" @click="updateStatus(todo)"
          >
            Not Done
          </button>
          <button 
            class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-red-500 hover:bg-red" @click="deleteTodo(todo)"
          >
            Remove
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
