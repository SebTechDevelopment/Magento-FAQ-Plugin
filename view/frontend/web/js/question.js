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
            questionsData: [],
            categoryData: [],
            tracks: {
                questionsData: true,
                totalQuestions: true,
                isLoading: true,
                categoryData: true,
            }
        },

        getQuestionsData: function() {
            return this.questions;
        },

        getCategoriesData: function () {
            return this.categories;
        },

        getTotalQuestions: function() {
            var totalQuestions = 0;
            this.questionsData.forEach(function (question) {
                if(question.enabled === "1") {
                    totalQuestions++
                }
            })
            return totalQuestions;
        },

        getQuestions: function() {
            return this.questionsData;
        },

        getCategories: function() {
            return this.categoryData;
        },

        initialize: function() {
            this._super();
            var self = this;
            self.questionsData = this.getQuestionsData();
            self.categoryData = this.getCategoriesData();
            self.totalQuestions = this.getTotalQuestions();
            self.isLoading = false;
        }
    })
})
