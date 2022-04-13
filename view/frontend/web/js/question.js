define([
    'uiComponent'
], function(
    Component
) {
    'use strict'
    return Component.extend({
        defaults: {
            title: "FAQ Homepage",
            template: 'SebTech_FAQTwo/question',
            totalQuestions: 0,
            isLoading: true,
            allQuestions: [],
            questionsData: [],
            categoryData: [],
            tracks: {
                questionsData: true,
                totalQuestions: true,
                isLoading: true,
                categoryData: true,
                allQuestions: true,
            }
        },

        getQuestionsData: function() {
            return this.questions;
        },

        getCategoriesData: function () {
            return this.categories;
        },

        getTotalQuestions: function() {
            let totalQuestions = 0;
            this.questionsData.forEach(function (question) {
                if(question.enabled === "1") {
                    totalQuestions++
                }
            })
            return totalQuestions;
        },

        getTotalCategories: function() {
            let totalCategories = 0;
            this.categoryData.forEach(function (category) {
                if(category.enabled === "1") {
                    totalCategories++
                }
            })
            return totalCategories;
        },

        getQuestions: function() {
            return this.questionsData;
        },

        getCategories: function() {
            return this.categoryData;
        },

        getQuestionsByCategory: function(category) {
            let categoryId = category.id;
            this.questionsData = [];

            this.allQuestions.forEach(question => {
                if(question.category_id === categoryId) {
                    this.questionsData.push(question);
                }
            })
        },

        initialize: function() {
            this._super();
            const self = this;
            self.questionsData = this.getQuestionsData();
            self.allQuestions = this.getQuestionsData();
            self.categoryData = this.getCategoriesData();
            self.totalQuestions = this.getTotalQuestions();
            self.isLoading = false;
        }
    })
})
