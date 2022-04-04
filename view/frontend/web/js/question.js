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
            tracks: {
                questionsData: true,
                totalQuestions: true,
                isLoading: true,
            }
        },

        getQuestionsData: function() {
            return this.questions;
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

        initialize: function() {
            this._super();
            var self = this;
            self.questionsData = this.getQuestionsData();
            self.totalQuestions = this.getTotalQuestions();
            self.isLoading = false;
        }
    })
})
