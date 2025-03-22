

import { useState } from "react";
import { Send, Search, GraduationCap } from "lucide-react";
const API_KEY = 'AIzaSyCVRog1SApsPo9x7wTWjopkb4KP9GaPADI'; // Replace with your actual YouTube Data API key
const API_URL = 'https://www.googleapis.com/youtube/v3/search';

function App() {
  const [query, setQuery] = useState("");
  const [results, setResults] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [selectedVideo, setSelectedVideo] = useState(null);

  const handleSearch = async (e) => {
    e.preventDefault();
    if (!query.trim()) return;
    setIsLoading(true);

    try {
      const educationalKeywords = "education|tutorial|learning|lecture|study|course|university";
      const response = await fetch(
        `${API_URL}?part=snippet&q=${encodeURIComponent(
          `${query} ${educationalKeywords}`
        )}&type=video&maxResults=10&key=${API_KEY}`
      );
      const data = await response.json();

      if (data.items) {
        setResults(
          data.items.map((item) => ({
            id: item.id.videoId,
            title: item.snippet.title,
            thumbnail: item.snippet.thumbnails.high.url,
            channel: item.snippet.channelTitle,
          }))
        );
      }
    } catch (error) {
      console.error("Error fetching YouTube videos:", error);
    }

    setIsLoading(false);
  };

  return (
    <div className="container mx-auto px-4 py-8">
      <div className="max-w-6xl mx-auto">
        {/* Header */}
        <div className="flex items-center justify-center mb-8">
          <GraduationCap className="w-12 h-12 text-purple-300 mr-3" />
          <h1 className="text-4xl font-bold text-white">
            Vidya<span className="text-purple-300">Search</span>
          </h1>
        </div>

        {/* Search Form */}
        <form onSubmit={handleSearch} className="mb-12">
          <div className="relative flex items-center">
            <input
              type="text"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder="Search for educational videos..."
              className="w-full px-8 py-5 rounded-full bg-white/10 border border-purple-300/20 text-white placeholder-purple-200"
            />
            <button type="submit" className="absolute right-3 p-3 bg-gradient-to-r from-blue-500 to-purple-500">
              {isLoading ? <Search className="w-6 h-6 text-white animate-spin" /> : <Send className="w-6 h-6 text-white" />}
            </button>
          </div>
        </form>

        {/* Enlarged Selected Video */}
        {selectedVideo && (
          <div className="mb-8">
            <iframe
              src={`https://www.youtube.com/embed/${selectedVideo.id}`}
              title={selectedVideo.title}
              className="w-full h-[500px] rounded-lg shadow-lg"
              allowFullScreen
            ></iframe>
            <h3 className="text-white text-2xl font-bold mt-4">{selectedVideo.title}</h3>
            <p className="text-sm text-purple-300">{selectedVideo.channel}</p>
          </div>
        )}

        {/* Video Thumbnails Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {results.map((result) => (
            <div
              key={result.id}
              className="bg-white/10 rounded-xl overflow-hidden cursor-pointer hover:scale-105 transition-transform"
              onClick={() => setSelectedVideo(result)}
            >
              <img src={result.thumbnail} alt={result.title} className="w-full h-52 object-cover" />
              <div className="p-5">
                <h3 className="text-white">{result.title}</h3>
                <p className="text-sm text-purple-300">{result.channel}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

export default App;
