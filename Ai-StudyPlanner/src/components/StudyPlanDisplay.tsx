import React from 'react';
import { Clock, CheckCircle, Calendar, Lightbulb } from 'lucide-react';
import { StudyPlan } from '../types';

interface StudyPlanDisplayProps {
  plan: StudyPlan[];
  daysRemaining: number;
}

export default function StudyPlanDisplay({ plan, daysRemaining }: StudyPlanDisplayProps) {
  if (plan.length === 0) {
    return (
      <div className="flex flex-col items-center justify-center h-full text-gray-500">
        <Calendar className="w-12 h-12 mb-4" />
        <p className="text-lg">Enter your subjects and generate a study plan</p>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-xl font-semibold">Your Study Plan</h2>
        <div className="flex items-center text-indigo-600">
          <Clock className="w-5 h-5 mr-2" />
          <span>{daysRemaining} days remaining</span>
        </div>
      </div>

      <div className="space-y-4">
        {plan.map((item, index) => (
          <div key={index} className="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div className="flex items-center justify-between mb-3">
              <h3 className="text-lg font-semibold text-gray-800">{item.subject}</h3>
              <span className="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                {item.hoursPerDay} hours/day
              </span>
            </div>

            <div className="space-y-3">
              <div>
                <h4 className="text-sm font-medium text-gray-700 mb-2">Key Topics:</h4>
                <ul className="list-disc list-inside space-y-1">
                  {item.keyPoints.map((point, i) => (
                    <li key={i} className="text-gray-600 text-sm">{point}</li>
                  ))}
                </ul>
              </div>

              <div>
                <h4 className="text-sm font-medium text-gray-700 mb-2">Daily Goals:</h4>
                <ul className="space-y-2">
                  {item.dailyGoals.map((goal, i) => (
                    <li key={i} className="flex items-center text-sm text-gray-600">
                      <CheckCircle className="w-4 h-4 text-green-500 mr-2" />
                      {goal}
                    </li>
                  ))}
                </ul>
              </div>

              {item.aiRecommendations && (
                <div>
                  <h4 className="text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <Lightbulb className="w-4 h-4 text-yellow-500 mr-2" />
                    AI Recommendations:
                  </h4>
                  <ul className="space-y-2">
                    {item.aiRecommendations.map((recommendation, i) => (
                      <li key={i} className="text-sm text-gray-600 pl-6 relative">
                        <span className="absolute left-0">•</span>
                        {recommendation}
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </div>
          </div>
        ))}
      </div>

      <div className="bg-indigo-50 p-4 rounded-lg">
        <h4 className="font-medium text-indigo-800 mb-2">Study Tips:</h4>
        <ul className="list-disc list-inside space-y-1 text-sm text-indigo-700">
          <li>Take regular breaks to maintain focus</li>
          <li>Review previous day's material before starting new topics</li>
          <li>Use active recall techniques while studying</li>
          <li>Stay hydrated and maintain a healthy schedule</li>
        </ul>
      </div>
    </div>
  );
}