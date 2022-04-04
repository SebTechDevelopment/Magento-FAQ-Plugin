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
            questionsData: [],
            tracks: {
                questionsData: true,
                totalQuestions: true
            }
        },

        getQuestionsData: function() {
            return this.questions;
        },

        getTotalQuestions: function() {
           return Object.keys(this.questionsData).length
        },

        getQuestions: function() {
            var something = Object.entries(this.questionsData);

            something.forEach(function (item) {
                console.log(item.title)
            })

        },

        initialize: function() {
            this._super();
            var self = this;
            self.questionsData = this.getQuestionsData();
            self.totalQuestions = this.getTotalQuestions();
        }
    })
})
