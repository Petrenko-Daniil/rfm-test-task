import {ref} from 'vue'
import {defineStore} from 'pinia'

export const useCardTagColorStore = defineStore('cardTagColor', () => {
    let counter = 0;
    const colors = ref([
        'bg-sky-500',
        'bg-orange-400',
        'bg-lime-500',
        'bg-green-500',
        'bg-teal-500'
    ])

    function getTagColorClass() {
        if (counter < colors.value.length - 1) {
            counter++;
            return colors.value[counter];
        }
        counter = 0;
        return colors.value[counter];
    }

    return {colors, getTagColorClass}
})
