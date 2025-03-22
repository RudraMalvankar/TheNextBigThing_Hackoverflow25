import React from 'react';
import { Plus, Trash2, BookOpen } from 'lucide-react';
import { Subject } from '../types';

interface SubjectFormProps {
  subjects: Subject[];
  setSubjects: React.Dispatch<React.SetStateAction<Subject[]>>;
}

export default function SubjectForm({ subjects, setSubjects }: SubjectFormProps) {
  const addSubject = () => {
    setSubjects([...subjects, { name: '', importance: 3, topics: [''] }]);
  };

  const removeSubject = (index: number) => {
    setSubjects(subjects.filter((_, i) => i !== index));
  };

  const updateSubject = (index: number, field: keyof Subject, value: any) => {
    const newSubjects = [...subjects];
    newSubjects[index] = { ...newSubjects[index], [field]: value };
    setSubjects(newSubjects);
  };

  const updateTopic = (subjectIndex: number, topicIndex: number, value: string) => {
    const newSubjects = [...subjects];
    newSubjects[subjectIndex].topics[topicIndex] = value;
    setSubjects(newSubjects);
  };

  const addTopic = (subjectIndex: number) => {
    const newSubjects = [...subjects];
    newSubjects[subjectIndex].topics.push('');
    setSubjects(newSubjects);
  };

  const removeTopic = (subjectIndex: number, topicIndex: number) => {
    const newSubjects = [...subjects];
    newSubjects[subjectIndex].topics = newSubjects[subjectIndex].topics.filter(
      (_, i) => i !== topicIndex
    );
    setSubjects(newSubjects);
  };

  return (
    <div className="space-y-6">
      {subjects.map((subject, index) => (
        <div key={index} className="bg-gray-50 p-6 rounded-lg border border-gray-200">
          <div className="flex items-center justify-between mb-4">
            <div className="flex-1">
              <input
                type="text"
                value={subject.name}
                onChange={(e) => updateSubject(index, 'name', e.target.value)}
                placeholder="Subject Name"
                className="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              />
            </div>
            <button
              onClick={() => removeSubject(index)}
              className="ml-2 text-red-500 hover:text-red-700 transition-colors duration-200"
            >
              <Trash2 size={20} />
            </button>
          </div>

          <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Importance Level
            </label>
            <input
              type="range"
              min="1"
              max="5"
              value={subject.importance}
              onChange={(e) => updateSubject(index, 'importance', parseInt(e.target.value))}
              className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
            />
            <div className="flex justify-between text-sm text-gray-500 mt-1">
              <span>Less Important</span>
              <span>Very Important</span>
            </div>
          </div>

          <div className="space-y-3">
            <div className="flex items-center">
              <BookOpen size={16} className="text-indigo-600 mr-2" />
              <span className="text-sm font-medium text-gray-700">Key Topics</span>
            </div>
            {subject.topics.map((topic, topicIndex) => (
              <div key={topicIndex} className="flex items-center">
                <input
                  type="text"
                  value={topic}
                  onChange={(e) => updateTopic(index, topicIndex, e.target.value)}
                  placeholder="Enter topic"
                  className="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                />
                <button
                  onClick={() => removeTopic(index, topicIndex)}
                  className="ml-2 text-red-500 hover:text-red-700 transition-colors duration-200"
                >
                  <Trash2 size={16} />
                </button>
              </div>
            ))}
            <button
              onClick={() => addTopic(index)}
              className="flex items-center text-indigo-600 hover:text-indigo-700 transition-colors duration-200"
            >
              <Plus size={16} className="mr-1" />
              <span className="text-sm">Add Topic</span>
            </button>
          </div>
        </div>
      ))}

      <button
        onClick={addSubject}
        className="w-full flex items-center justify-center py-2 px-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 hover:text-indigo-500 transition-colors duration-200"
      >
        <Plus size={20} className="mr-2" />
        <span>Add Subject</span>
      </button>
    </div>
  );
}