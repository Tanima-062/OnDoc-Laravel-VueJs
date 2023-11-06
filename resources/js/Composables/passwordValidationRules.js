import { minLength, helpers } from '@vuelidate/validators'

export default function usePasswordValidationRules() {
    const includesUppercase = helpers.regex(/[A-Z]/)
    const includesLowercase = helpers.regex(/[a-z]/)
    const includesSpecialCharacter = helpers.regex(/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/)
    const includesNumber = helpers.regex(/[0-9]/)

    return {
        minLength: helpers.withMessage('The password must be at least 8 characters.', minLength(8)),
        upperCase: helpers.withMessage('The password must contain at least one uppercase and one lowercase letter.', includesUppercase),
        lowerCase: helpers.withMessage('The password must contain at least one uppercase and one lowercase letter.', includesLowercase),
        specialCharacter: helpers.withMessage('The password must contain at least one symbol.', includesSpecialCharacter),
        number: helpers.withMessage('The password must contain at least one number.', includesNumber),
    }
}
