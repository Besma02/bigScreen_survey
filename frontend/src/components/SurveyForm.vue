<template>
  <div class="survey-form px-4 py-8  max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold mb-8 text-center">Survey Bigscreen</h2>

    <form @submit.prevent="submitSurvey">
      <!-- Iterate over questions -->
      <div v-for="(question, index) in questions" :key="index" class="mb-8">
        <div class="question-header mb-4">
          <p class="font-medium text-lg">{{ index + 1 }}. {{ question.title }}</p>
        </div>

        <!-- Different types of input fields -->
        <div v-if="question.type === 'email'" class="mt-4">
          <input
            type="email"
            v-model="answers[index]"
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Enter your email"
            required
          />
        </div>

        <div v-else-if="question.type === 'A'" class="choices space-y-4">
          <div v-for="(choice, i) in question.options" :key="i" class="flex items-center">
            <input
              type="radio"
              :id="'question-' + index + '-option-' + i"
              v-model="answers[index]"
              :value="choice"
              class="mr-2 h-5 w-5 text-blue-500 border-gray-300 rounded"
            />
            <label :for="'question-' + index + '-option-' + i" class="text-sm text-gray-700">
              {{ choice }}
            </label>
          </div>
        </div>

        <div v-else-if="question.type === 'B'" class="mt-4">
          <input
            type="text"
            v-model="answers[index]"
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="question.placeholder"
            :maxlength="question.maxLength || 255"
          />
        </div>

        <div v-else-if="question.type === 'C'" class="range mt-4">
          <input
            type="range"
            v-model="answers[index]"
            :min="1"
            :max="5"
            class="w-full h-2 bg-blue-200 rounded-lg focus:outline-none"
          />
          <div class="text-center mt-2 text-sm text-gray-600">{{ answers[index] }}</div>
        </div>
      </div>

      <!-- Submit button -->
      <div class="text-center mt-8">
        <button
          type="submit"
          class="px-6 py-3 bg-blue-500 text-white text-lg font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
        >
          Submit
        </button>
      </div>
    </form>

    <!-- Modal Confirmation -->
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg p-8 max-w-md mx-auto text-center shadow-xl">
        <h3 class="text-2xl font-bold text-green-600 mb-4">Merci pour vos réponses !</h3>
        <p class="mb-4">
          Toute l’équipe de Bigscreen vous remercie pour votre engagement. Grâce à votre
          investissement, nous vous préparons une application toujours plus facile à utiliser, seul ou en famille.
        </p>
        <p class="mb-2">Consultez vos réponses ici :</p>
        <p class="text-blue-600 underline break-words mb-6">{{ resultUrl }}</p>
        <button @click="closeModal" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center gap-2">
  Voir mes réponses ➡️
</button>

      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { useRouter } from 'vue-router';
const router = useRouter();


const toast = useToast();

const formSubmitted = ref(false);
const resultUrl = ref('');
const showModal = ref(false);

const questions = ref([
  { id: 1, title: "Email address", type: "email" },
  { id: 2, title: "Your age", type: "B", placeholder: "Enter your age" },
  { id: 3, title: "Your gender", type: "A", options: ["Male", "Female", "Prefer not to say"] },
  { id: 4, title: "Number of people in your household", type: "C" },
  { id: 5, title: "Your occupation", type: "B", placeholder: "Enter your occupation" },
  { id: 6, title: "What brand of VR headset do you use?", type: "A", options: ["Oculus Quest", "Oculus Rift/s", "HTC Vive", "Windows Mixed Reality", "Valve Index"] },
  { id: 7, title: "Which app store do you use to purchase VR content?", type: "A", options: ["SteamVR", "Oculus Store", "Viveport", "Windows Store"] },
  { id: 8, title: "Which VR headset are you considering purchasing in the near future?", type: "A", options: ["Oculus Quest", "Oculus Go", "HTC Vive Pro", "PSVR", "Other", "None"] },
  { id: 9, title: "How many people in your household use your VR headset to watch Bigscreen?", type: "C" },
  { id: 10, title: "You primarily use Bigscreen for:", type: "A", options: ["Watching live TV", "Watching movies", "Working", "Solo gaming", "Multiplayer gaming"] },
  { id: 11, title: "How would you rate the image quality on Bigscreen?", type: "C" },
  { id: 12, title: "How would you rate the ease of use of the Bigscreen interface?", type: "C" },
  { id: 13, title: "How would you rate the network connection on Bigscreen?", type: "C" },
  { id: 14, title: "How would you rate the 3D graphics quality in Bigscreen?", type: "C" },
  { id: 15, title: "How would you rate the audio quality in Bigscreen?", type: "C" },
  { id: 16, title: "Would you like more precise notifications during your Bigscreen sessions?", type: "A", options: ["Yes", "No"] },
  { id: 17, title: "Would you like to invite a friend to join your session via their smartphone?", type: "A", options: ["Yes", "No"] },
  { id: 18, title: "Would you like to record TV shows to watch later?", type: "A", options: ["Yes", "No"] },
  { id: 19, title: "Would you like to play exclusive games on your Bigscreen?", type: "A", options: ["Yes", "No"] },
  { id: 20, title: "What new feature should be available on Bigscreen?", type: "B", placeholder: "Enter your suggestion" }
]);

const answers = ref(new Array(questions.value.length).fill(""));

const submitSurvey = async () => {
  const allAnswered = answers.value.every(answer => answer !== "");
  if (!allAnswered) {
    toast.error("Please answer all the questions.");
    return;
  }

  const email = answers.value[0];
  const formattedAnswers = questions.value.map((question, index) => ({
    question_id: question.id,
    value: answers.value[index]
  }));

  try {
    const response = await axios.post('http://localhost:8000/api/survey/submit', {
      email,
      answers: formattedAnswers
    });
    formSubmitted.value = true;
    resultUrl.value = response.data.url;
    showModal.value = true;
    toast.success('Survey submitted successfully!');
  } catch (error) {
    toast.error('Error submitting the survey.');
    console.error('Error submitting the survey:', error);
  }
};

const closeModal = () => {
  showModal.value = false;
  const token = resultUrl.value.split('/').pop(); // récupère le token depuis l'URL
  router.push({ name: 'SurveyResult', params: { token } });
};
</script>
<style scoped>
.survey-form {
  padding: 2rem;
  max-width: 900px;
  margin: auto;
}
.question-header {
  font-size: 1.25rem;
}
.choices label {
  display: block;
  margin-bottom: 0.5rem;
}
.range input {
  width: 100%;
}

/* Pour que le modal soit centré proprement */
</style>
