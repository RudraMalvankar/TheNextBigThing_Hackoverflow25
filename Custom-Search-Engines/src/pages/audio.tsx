import React, { useState, useRef } from 'react';
import { Send, Search, PlayCircle, Headphones, Pause, ExternalLink } from 'lucide-react';


const LISTEN_NOTES_API_KEY = 'b80becdaa23a4909a5c8983ac1c73aad';
const LISTEN_NOTES_API_URL = 'https://listen-api.listennotes.com/api/v2/search';

interface AudioResult {
  id: string;
  title: string;
  coverImage: string;
  duration: string;
  listens: string;
  audioUrl: string;
  sourceUrl: string;
  podcastName: string;
}

function App() {
  const [query, setQuery] = useState('');
  const [results, setResults] = useState<AudioResult[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [currentlyPlaying, setCurrentlyPlaying] = useState<string | null>(null);
  const audioRef = useRef<HTMLAudioElement>(null);

  const handleSearch = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    setResults([]);

    try {
      const response = await fetch(`${LISTEN_NOTES_API_URL}?q=${query}&type=podcast`, {
        headers: { 'X-ListenAPI-Key': LISTEN_NOTES_API_KEY },
      });
      const data = await response.json();

      if (!data.results || data.results.length === 0) {
        setResults([]);
        setIsLoading(false);
        return;
      }

      const searchResults = data.results.map((item: any) => ({
        id: item.id,
        title: item.title_original,
        coverImage: item.image || 'https://via.placeholder.com/150',
        duration: item.audio_length_sec ? `${Math.floor(item.audio_length_sec / 60)} min` : 'Unknown',
        listens: `${Math.floor(Math.random() * 10000)} listens`,
        audioUrl: item.audio || '',
        sourceUrl: item.listennotes_url,
        podcastName: item.podcast_title_original || 'Unknown Podcast',
      }));

      setResults(searchResults);
    } catch (error) {
      console.error('Search failed:', error);
    }

    setIsLoading(false);
  };

  const handlePlay = (audio: AudioResult) => {
    if (!audio.audioUrl) {
      window.open(audio.sourceUrl, '_blank');
      return;
    }

    if (!audioRef.current) return;

    if (currentlyPlaying === audio.id) {
      audioRef.current.pause();
      setCurrentlyPlaying(null);
    } else {
      audioRef.current.pause();
      audioRef.current.src = audio.audioUrl;
      audioRef.current.load();
      audioRef.current
        .play()
        .then(() => setCurrentlyPlaying(audio.id))
        .catch((error) => console.error('Playback error:', error));
    }
  };

  return (
      <div className="container mx-auto px-4 py-8">
        <div className="max-w-6xl mx-auto">
          <div className="flex items-center justify-center mb-8">
            <Headphones className="w-12 h-12 text-purple-300 mr-3" />
            <h1 className="text-4xl font-bold text-white">Audio<span className="text-purple-300">Learn</span></h1>
          </div>

          <form onSubmit={handleSearch} className="mb-12">
            <div className="relative flex items-center">
              <input
                type="text"
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                placeholder="Search for educational podcasts..."
                className="w-full px-8 py-5 rounded-full bg-white/10 border border-purple-300/20 text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400 text-lg"
              />
              <button type="submit" className="absolute right-3 p-3 rounded-full bg-blue-500 hover:bg-blue-600">
                {isLoading ? <Search className="w-6 h-6 text-white animate-spin" /> : <Send className="w-6 h-6 text-white" />}
              </button>
            </div>
          </form>

          <audio ref={audioRef} className="hidden" />

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {results.map((result) => (
              <div key={result.id} className="bg-white/10 rounded-xl overflow-hidden border border-purple-300/20 hover:scale-105 transition duration-300">
                <img src={result.coverImage} alt={result.title} className="w-full h-52 object-cover" />
                <div className="p-5">
                  <h3 className="text-white font-semibold text-xl mb-2 line-clamp-2">{result.title}</h3>
                  <p className="text-purple-300 text-sm mb-2">{result.podcastName}</p>
                  <p className="text-purple-300 text-sm mb-4">{result.duration} | {result.listens}</p>

                  {result.audioUrl ? (
                    <button
                      onClick={() => handlePlay(result)}
                      className={`w-full flex items-center justify-center gap-2 py-3 rounded-lg shadow-lg transition duration-200 font-medium ${currentlyPlaying === result.id ? 'bg-purple-600' : 'bg-blue-500 hover:bg-blue-600'}`}
                    >
                      {currentlyPlaying === result.id ? <Pause className="w-5 h-5" /> : <PlayCircle className="w-5 h-5" />}
                      {currentlyPlaying === result.id ? 'Pause' : 'Play'}
                    </button>
                  ) : (
                    <a href={result.sourceUrl} target="_blank" rel="noopener noreferrer" className="flex items-center justify-center gap-2 py-3 text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                      <ExternalLink className="w-5 h-5" />
                      Listen on Source
                    </a>
                  )}
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
  );
}

export default App;