import "./size-checker.js";

export function evaluateSize(field, inputVal, ideal, tolerance) {
    const diff = inputVal - ideal;
    const { just, slight, long_or_short } = tolerance;

    if (diff >= just.min_value && diff <= just.max_value) {
        return { result: "✅ ちょうどいい", class: "text-green-600" };
    } else if (diff >= slight.min_value && diff <= slight.max_value) {
        return { result: "△ やや合わない", class: "text-yellow-500" };
    } else {
        return { result: "✕ 大きく合わない", class: "text-red-600" };
    }
}
